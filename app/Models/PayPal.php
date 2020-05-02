<?php

namespace App\Models;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
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
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // $item1 = new Item();
        // $item1->setName('Ground Coffee 40 oz')
        //     ->setCurrency('BRL')
        //     ->setQuantity(1)
        //     ->setPrice(7.5);

        // Items do carrinho
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

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details
            // ->setShipping(1.2)
            // ->setTax(1.3)
            ->setSubtotal($this->cart->total());

        $amount = new Amount();
        $amount->setCurrency("BRL")
            ->setTotal($this->cart->total())
                ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Compra de items do carrinho.")
            ->setInvoiceNumber($this->identity  );

        $baseRoute = route('return.paypal');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("{$baseRoute}?success=true")
            ->setCancelUrl("{$baseRoute}?success=false");

        $payment = new Payment();
        $payment->setIntent("order")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $request = clone $payment;

        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            // ResultPrinter::printError("Created Payment Order Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
            exit(1);
        }

        $approvalUrl = $payment->getApprovalLink();

        // ResultPrinter::printResult("Created Payment Order Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

        return $approvalUrl;

    }
}
