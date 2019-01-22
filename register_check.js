function check() {
    if (document.getElementById('password').value === document.getElementById('password-check').value &&
        document.getElementById('password').value !== '' && document.getElementById('password-check').value !== '') {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'matching';
        document.getElementById('btnSubmit').disabled = false;
        document.getElementById('btnSubmit').style.opacity = "1";
        document.getElementById('btnSubmit').style.cursor = 'pointer';
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'not matching';
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').style.opacity = "0.5";
        document.getElementById('btnSubmit').style.cursor = 'default';
    }
}
