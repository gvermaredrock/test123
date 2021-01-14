const clicktocallbutton = document.querySelector('#clicktocallbutton');
const askforphonebutton = document.querySelector('#askforphonebutton');
const askforphoneform = document.querySelector('#askforphoneform');
const askforotpbutton = document.querySelector('#askforotpbutton');
const askforotpform = document.querySelector('#askforotpform');
const userphone = document.querySelector('#userphone');
const listingid = document.querySelector('#listingid');
const userotp = document.querySelector('#otp');
const token = document.querySelector('#csrftoken');
const finaldata = document.querySelector('#finaldata');
function sendUserPhone(){
    let phone = { _token: token.value, email: userphone.value};
    fetch('https://my.wuchna.com/clicktocall', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(phone)
    }) .then(response => response.text()) .then(data => {
            if(data == 'error'){console.log('An error happened. Please email to info@wuchna.com');}else {
                askforphoneform.classList.add("hidden");
                askforotpform.classList.remove("hidden");
            }
        });
};

function otpEntered(){
    let phone = { _token: token.value, email: userphone.value, otp: userotp.value,listing:listingid.value};
    fetch('https://my.wuchna.com/clicktocallotp', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(phone)
    }) .then(response => response.text()) .then(data => {
            if(data == 'wrongotp'){console.log('Wrong OTP Entered');}else {
                finaldata.classList.remove("hidden");
                askforotpform.classList.add("hidden");
                clicktocallbutton.classList.add("hidden");
            }
        });
};

clicktocallbutton.addEventListener('click', () => {
    askforphoneform.classList.remove("hidden");
});
askforphonebutton.addEventListener('click', sendUserPhone);
askforotpbutton.addEventListener('click', otpEntered);

