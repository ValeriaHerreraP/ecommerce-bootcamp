<?php

namespace App\Http\Controllers;

use App\Models\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Str;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;



class CartController extends Controller
{
    public function shop(Request $request)
    {
    
        //muestra los productos
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(6);

        return view('cart.shop', ['products' => $product]);
    }

    public function cart()
    {
        //Se muestran los productos añadidos
        $cartCollection = \Cart::getContent();
        //dd($cartCollection);
        return view('cart.cart', ['cartCollection' => $cartCollection]);
    }

    public function remove(Request $request)
    {
        //Elimina el producto seleccionado
        \Cart::remove($request->id);

        return redirect()->route('cart.index');
    }

    public function add(Request $request)
    {
        //añade el producto al carrito
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $request->img,
         ],
        ]);

        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {
        //Modifica la cantidad
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity,
                ],
        ]
        );

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        //Elimina todos los elementos del carrito
        \Cart::clear();

        return redirect()->route('cart.index')->with('success_msg', 'Carrito sin productos.');
    }

    public function pagos(Request $request)
    {
       // dd(\Cart::getTotal());
       $price = \Cart::getTotal();

      $nuevaorden=  Payment::create([
        'user_id' => auth()->id(),
        'price_sum' => $price,
        
    ]);
   // $request ->all()

   //dd($request);

    $result = Http::post(config('credentialesEvertec.url').'/api/session',
 $this->createRequest($nuevaorden, $request->ip(), $request->userAgent())
);

    if($result -> ok()) {
        $nuevaorden->order_id = $result->json()['requestId'];
        $nuevaorden->url = $result->json()['processUrl'];  

        $nuevaorden->update();
        //actualizar datos

        redirect()->to($nuevaorden->url)->send();
    }

    //redirigir al usuario a un lugar para indicarle porque no funciono

    throw new \Exception($result->body());

      \Cart::clear();

        return view('cart.payments');
    }



    private function getAuth(): array
    {
        $nonce = rand();
        $seed = date(format:'c');
        return [
            'login'=> config('credentialesEvertec.login') ,
            'tranKey'=> base64_encode(
                hash(
                'sha256',
                $nonce.$seed.config('credentialesEvertec.tranKey'),
                true,
                 )
            ),
            'nonce'=> base64_encode($nonce),
            'seed' => $seed,
        ];
    
    }
    
    private function createRequest(Payment $nuevaorden, string $ipAdress, string $userAgent):array
    {
        return[
            'auth' => $this->getAuth(),
            'buyer' => [
                'name' => auth()->user()->name,
                'lastname' => auth()->user()->lastname,
                'email' => auth()->user()->email,
    
            ],
            'payment' => [
                'reference' => $nuevaorden->id,
                'description' => 'prueba',
                'amount' => [
                    'currency' => 'COP',
                    'total' => \Cart::getTotal(),
                ]
                ],
    
            'expiration' => Carbon::now()->addHour(),
            'returnUrl' => route('cart.shop'),
            'ipAddress' => $ipAdress,
            'userAgent' => $userAgent,
    
            ];
    }
    
    }
    

  /*  public function uu (Request $request)
    {


        \Cart::add(array(
            'id' => 456, // inique row ID
            'name' => 'Sample Item',
            'price' => 67.99,
            'quantity' => 4,
            'attributes' => array()
        ));

        \Cart::update(456, array(
            'name' => 'New Item Name', // new item name
            'price' => 98.67, // new item price, price can also be a string format like so: '98.67'
          ));

          \Cart::remove(456);

        $cartCollection = \Cart::getContent();
        dd($cartCollection);


        return view('productos', ['products' => $product]);

    }

    public function cart()  {

        $cartCollection = \Cart::getContent();
        dd($cartCollection);

        return view('cart');
    }
    */
