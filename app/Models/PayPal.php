<?php

namespace App\Models;

use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;


class PayPal
{
    private $apiContext;
    private $identity;
    private $cart;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret_id'))
        );

        $this->apiContext->setConfig(config('paypal.settings'));

        $this->identity = bcrypt(uniqid(date('ymdHis')));

        $this->cart = new Cart();
    }

    public function generate()
    {
        $payment = new Payment();
        $payment->setIntent("order")
            ->setPayer($this->payer())
            ->setRedirectUrls($this->redirectUrls())
            ->setTransactions(array($this->transaction()));

        try {
            $payment->create($this->apiContext);

            $paymentId = $payment->getId();

            $order = Order::create([
                'user_id'   => auth()->user()->id,
                'total'     => $this->cart->total(),
                'status'    => 'started',
                'payment_id'=> $paymentId,
                'identity'  => $this->identity,
            ]);

            $items = $this->cart->getItems();
            $productsOrder = [];
            foreach($items as $item){
                $productsOrder[$item['item']->id] = [
                    'qtd'   => $item['qtd'],
                    'price' => $item['item']->price
                ];
            }
            $order->products()->attach($productsOrder);

            $approvalUrl = $payment->getApprovalLink();

            return [
                'status' => true,
                'url_paypal' => $approvalUrl
            ];
        } catch (PayPalConnectionException| Exception $ex) {
            return [
                'status' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    public function payer()
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        return $payer;
    }

    // Items do carrinho
    public function items()
    {
        $itemsCart =$this->cart->getItems();
        $items = [];
        foreach($itemsCart as $itemCart){
            $item = new Item();
            $item->setName($itemCart['item']->name)
                ->setCurrency('BRL')
                ->setQuantity($itemCart['qtd'])
                ->setPrice($itemCart['item']->price);
            $items[] = $item;
        }

        return $items;
    }

    public function itemList()
    {
        $itemList = new ItemList();
        $itemList->setItems($this->items());

        return $itemList;
    }

    public function details()
    {
        $details = new Details();
        $details
            // ->setShipping(1.2)
            // ->setTax(1.3)
            ->setSubtotal($this->cart->total());

        return $details;
    }

    public function amount()
    {
        $amount = new Amount();
        $amount->setCurrency("BRL")
            ->setTotal($this->cart->total())
                ->setDetails($this->details());
        return $amount;
    }

    public function transaction()
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount())
            ->setItemList($this->itemList())
            ->setDescription("Compra de items do carrinho.")
            ->setInvoiceNumber($this->identity);
        return $transaction;
    }

    public function redirectUrls()
    {
        $baseRoute = route('return.paypal');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("{$baseRoute}?success=true")
            ->setCancelUrl("{$baseRoute}?success=false");

        return $redirectUrls;
    }

    public function execute($paymentId, $token, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);

        if($payment->getState() != 'approved'){
            $execution = new PaymentExecution();

            $execution->setPayerId($payerId);

            $result = $payment->execute($execution, $this->apiContext);

            return $result->getState();
        }

        return $payment->getState();
    }
}
