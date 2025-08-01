<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Invoice</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .font{
      font-size: 15px;
    }
    .authority {
        /*text-align: center;*/
        float: right
    }
    .authority h5 {
        margin-top: -10px;
        color: #EC5252;
        /*text-align: center;*/
        margin-left: 35px;
    }
    .thanks p {
        color: #EC5252;;
        font-size: 16px;
        font-weight: normal;
        font-family: serif;
        margin-top: 20px;
    }
</style>

</head>
<body>

  <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
          <!-- {{-- <img src="" alt="" width="150"/> --}} -->
          <h2 style="color: #EC5252; font-size: 26px;"><strong>Aduca</strong></h2>
          <br>
          <br>
          <h3><span style="color: #EC5252;">Invoice NO:</span> #{{ $payment->invoice_no }}</h3>
        </td>
        <td align="right">
            <pre class="font" >
               Aduca Head Office
               Email:support@aduca.com <br>
               Mob: +2347041660234 <br>
               Lagos, Nigeria <br>
              
            </pre>
        </td>
    </tr>

  </table>


  <table width="100%" style="background:white; padding:2px;"></table>

  <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
    <tr>
        <td>
          <p class="font" style="margin-left: 20px;">
           <strong>Name:</strong> {{ $payment->name }} <br>
           <strong>Email:</strong> {{ $payment->email }} <br>
           <strong>Phone:</strong> {{ $payment->phone }} <br>
            
           <strong>Address:</strong> {{ $payment->address }} <br>
           
         </p>
        </td>
        <td>
          <p class="font">
            {{-- <h3><span style="color: #EC5252;">Invoice:</span> #{{ $payment->invoice_no }}</h3> --}}
            <strong>Order Date:</strong> {{ $payment->order_date }} <br>
             <strong>Delivery Date:</strong> {{ $payment->order_date }} <br>
            <strong>Payment Type :</strong> {{ $payment->payment_type }} </span>
         </p>
        </td>
    </tr>
  </table>
  <br/>
<h3>Products</h3>


  <table width="100%">
    <thead style="background-color: #EC5252; color:#FFFFFF;">
      <tr class="font">
        <th>Image</th>
        <th>Course Name</th>
        <th>Unit Price </th>
        <th>Total </th>
      </tr>
    </thead>
    <tbody>


       
    @foreach ($orderItems as $item)    
      <tr class="font">
        <td align="center">
            <img src="{{ public_path($item->course->course_image) }}" height="60px;" width="60px;" alt="">
        </td>
        <td align="center">{{ $item->course->course_name }}</td>
        <td align="center">${{ $item->price }}</td>
        <td align="center">price Tk</td>
      </tr>
      @endforeach
      
    </tbody>
  </table>
  <br>
  <table width="100%" style=" padding:0 10px 0 10px;">
    <tr>
        <td align="right" >
            <h2><span style="color: #EC5252;">Subtotal:</span> ${{ $payment->total_amount }}</h2>
            <h2><span style="color: #EC5252;">Total:</span> ${{ $payment->total_amount }}</h2>
            {{-- <h2><span style="color: #EC5252;">Full Payment PAID</h2> --}}
        </td>
    </tr>
  </table>
  <div class="thanks mt-3">
    <p>Thanks For Buying Products..!!</p>
  </div>
  <div class="authority float-right mt-5">
      <p>-----------------------------------</p>
      <h5>Authority Signature:</h5>
    </div>
</body>
</html>