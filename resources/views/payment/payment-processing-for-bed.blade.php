<button id="rzp-button1" style="display:none;">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{$response['razorpayId']}}", // Enter the Key ID generated from the Dashboard
    "amount": "{{$response['amount']}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "{{$response['currency']}}",
    "name": "{{$response['name']}}",
    "description": "{{$response['description']}}",
    "image": "{{asset('assets/img/logo.png')}}",
    "order_id": "{{$response['orderId']}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){
        document.getElementById('rzp_paymentid').value= response.razorpay_payment_id;
        document.getElementById('rzp_orderid').value= response.razorpay_order_id;
        document.getElementById('rzp_signature').value= response.razorpay_signature;
        document.getElementById('rzp_paymentresponse').click();
    },
    "prefill": {
        "name": "{{$response['name']}}",
        "email": "{{$response['email']}}",
        "contact": "{{$response['mobile']}}",
    },
    "notes": {
        "address": ""
    },
    "theme": {
        "color": "#20C0F3"
    },
    "modal": {
        "ondismiss": function(){
            window.location.replace("{{route('patient.home')}}");
        }
    }
};
var rzp1 = new Razorpay(options);
window.onload = function(){
    document.getElementById('rzp-button1').click();
};
rzp1.on('payment.failed', function (response){
        // alert(response.error.code);
        // alert(response.error.description);
        // alert(response.error.source);
        // alert(response.error.step);
        // alert(response.error.reason);
        // alert(response.error.metadata);
    document.getElementById('error_code').value= response.error.code;
	document.getElementById('error_descripton').value= response.error.description;
	document.getElementById('error_source').value= response.error.source;
	document.getElementById('error_step').value= response.error.step;
	document.getElementById('error_reason').value= response.error.reason;
	document.getElementById('error_metadata').value= response.error.metadata;
	document.getElementById('rzp_paymentfailed').click();
});

document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

<form action="{{route('patient.complete.payment.bed')}}" method="post" hidden>
    @csrf
      <input type="hidden" name="_token" value='{{ csrf_token()}}'>
      <input type="text" name="rzp_paymentid" id="rzp_paymentid" class="form-control">
      <input type="text" name="rzp_orderid" id="rzp_orderid" class="form-control">
      <input type="text" name="rzp_signature" id="rzp_signature" class="form-control">
      <input type="text" name="bed_id" id="bed_id" value="{{$response['bed_id']}}" class="form-control">
      <input type="text" name="pay_amount" value="{{$response['amount']/100}}" class="form-control">
      <input type="text" name="check" id="check" value="{{$response['check']}}" class="form-control">
    
      <input type="text" name="wallet_price" id="wallet_price" value="{{$response['wallet_price']}}" class="form-control">
      <input type="text" name="coupon_code" id="coupon_code" value="{{$response['coupon_code']}}" class="form-control">
      <input type="text" name="source" id="source" value="{{$response['source']}}" class="form-control">
      <input type="text" name="coupon_price" id="coupon_price" value="{{$response['coupon_price']}}" class="form-control">
    
    <button type="submit" id="rzp_paymentresponse" class="btn btn-primary">Submit</button>
</form>
<form action="{{ route('patient.paymentfailed') }}" method="post" hidden>
    @csrf
      <input type="hidden" name="_token" value='{{ csrf_token()}}'>
      <input type="text" name="error_code" id="error_code" class="form-control">
      <input type="text" name="error_descripton" id="error_descripton" class="form-control">
      <input type="text" name="error_source" id="error_source" class="form-control">
      <input type="text" name="error_step" id="error_step" class="form-control">
      <input type="text" name="error_reason" id="error_reason" class="form-control">
      <input type="text" name="error_metadata" id="error_metadata" class="form-control">
      <button type="submit" id="rzp_paymentfailed" class="btn btn-primary">Submit</button>
</form>
  