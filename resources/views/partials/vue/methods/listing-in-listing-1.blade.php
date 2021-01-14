foundReviewHelpful(id){
axios.post(`/foundreviewhelpful/${id}`).then(res=>alert('Thanks!'));
},
copyToClipboard(id){
var copyText = document.getElementById(`hiddeninput-${id}`);
copyText.select();
copyText.setSelectionRange(0, 99999);
document.execCommand("copy");
alert("Copied the text: " + copyText.value);
},
@if(Auth::check())
    showClickToCallForm(id){
    const statement = 'this.toShowCallData'+id+'=true;';
    eval(statement);
    axios.post(`/leadgenerated/${id}`);
    },
@else
    showClickToCallForm(id){this.showingClickToCallForm = !this.showingClickToCallForm},
@endif
clickToCallFormSubmitted(){
axios.post('/clicktocall',{'email':this.$refs.clicktocallemail.value}).then(res=>{
if(res.data == 'error'){alert('Error. Please email to info@wuchna.com');}else{
this.showingClickToCallOtp = true; this.showingClickToCallForm = false;
}
})
},
clickToCallOtpSubmitted(){
axios.post('/clicktocallotp',{'email':this.$refs.clicktocallemail.value,'otp':this.$refs.clicktocallotp.value,'listing':this.showingListingId}).then(res=>{
if(res.data=='wrongotp'){alert('Wrong OTP Entered')}else{
this.showingClickToCallOtp = false;
statement = 'this.toShowCallData'+this.showingListingId+'=true;';
eval(statement);
alert('Thanks. You are now verified and logged in. You can now contact multiple vendors without asking OTP again, until you logoff');
console.log('done');
}
})
}
