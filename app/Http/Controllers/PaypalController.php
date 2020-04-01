<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;


class PaypalController extends Controller
{
    private $_api_context;

    public function __construct() 
    {
        //Setup Paypal api context
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'],$paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function postPayment()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items =array();
        $subtotal = 0;
        $cart = session('cart');
        $currency = "USD";
        //dd($cart); //extarct por photo;
    
        foreach($cart as $producto) {
            $item = new Item;
            $item->setName($producto['name'])
            ->setCurrency($currency)
            ->setDescription($producto['photo'])
            ->setQuantity($producto['quantity'])
            ->setPrice($producto['price']);

            $items[] = $item;
            $subtotal += $producto['quantity'] * $producto['price'];
        }
                
        $item_list = new ItemList();
        $item_list->setItems($items);

        $details = new Details;
        $details->setSubtotal($subtotal)
        ->setShipping(100);

        $total = $subtotal + 100;

        $amount = new Amount;
        $amount->setCurrency($currency)
        ->setTotal($total)
        ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Pedido de prueba');

        $baseUrl = "https://example.com";
        $redirect_urls = new RedirectUrls(); //\URL::
        $redirect_urls->setReturnUrl(route('paymentStatus'))
        ->setCancelUrl(route('paymentStatus'));
        $payment = new Payment();
        $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        }
            //PayPal\Exception\PPConnectionException
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if(\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                dd($err_data);
                exit;
            } else {
                die ("Ups, algo salió mal");
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        session()->put('paypal_payment_id', $payment->getId());
        
        if(isset($redirect_url)) {
            //redirect to PayPal
            return \Redirect::away($redirect_url);
        }

        return \Redirect::route('cart')
        ->with('success','Ups, error desconocido');

        /*  credit_card = new CreditCard()
                        {
                            billing_address = new Address()
                            {
                                city = "Johnstown",
                                country_code = "US",
                                line1 = "52 N Main ST",
                                postal_code = "43210",
                                state = "OH"
                            },
                            cvv2 = "874",
                            expire_month = 11,
                            expire_year = 2018,
                            first_name = "Joe",
                            last_name = "Shopper",
                            number = "4024007185826731", //New Credit card Number, Only Card type should match other details does not matter
                            type = "visa"
                        }
        */
    }

    public function getPaymentStatus(Request $request) {
        $payment_id = session()->get('paypal_payment_id');

        \Session::forget('paypal_payment_id');

        $url = url()->full();
        $parsed_url = parse_url($url);
        $query_string = $parsed_url["query"];
        parse_str($query_string,$array_of_query_string);
        $payerId=$array_of_query_string['PayerID'];
        $token = $array_of_query_string['token'];
        
        if(empty($payerId) || empty($token)) {
            return \Redirect::route('AddProduct')
            ->with('success','Hubo un problema al intentar pagar con PayPal');
        }

        $payment = Payment::get($payment_id,$this->_api_context);

        $execution = new PaymentExecution();
        //$execution->setPayerId(\Input::get('PayerID'));
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution,$this->_api_context);

        if($result->getState() == 'approved') {

            //TOMAR INFORMACION DE LA VENTA Y GUARDA EN LA BASE DE DATOS
            $this->saveOrder();
            \session::forget('cart');

            return \Redirect::route('cart')
            ->with('success', 'Compra realizada de forma correcta');
            //->with('message','Compra realizada de forma correcta');
        }
        return \Redirect::route('cart')
        ->with('success','La compra fue cancelada!');
    }

    protected function saveOrder() {
        $subtotal=0;
        $cart = \session::get('cart');

        foreach($cart as $producto) {
            $subtotal += $producto->quantity * $producto->price;
        }
        $order = Order::create([
            'subtotal'=>$subtotal,
            'shipping'=>0,
            'user_id'=>\Auth::user()
        ]);
        foreach($cart as $producto) {
            $this->saveOrderItem($producto,$order->id);
        }
    }

    protected function saveOrderItem($producto,$order_id) {
        OrderItem::create([
            'price'=>$producto->price,
            'quantity'=>$producto->quantity,
            'product_id'=>$producto->id,
            'order_id'=>$producto->order_id
        ]);
    }
}
