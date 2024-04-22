$(document).ready(function() {
    $("#contact-save").validate({
        rules: {
            name : {
                required: true,
                minlength: 3
            },
            subject: {
                required: true,
                minlength: 3
            },
            phone: {
                number: true
            },
            email: {
                required: true,
                email: true
            },
            description: {
                required: true,
                minlength: 10
            },
        },
        messages : {
            name: {
                minlength: "Nama harus minimal 3 karakter",
                required: "Nama harus diisi"
            },
            subject: {
                required: "Please enter your age",
                minlength: "Subject harus minimal 3 karakter"
            },
            email: {
                required: "Email harus diisi",
                email: "Email harus dalam format: abc@domain.tld"
            },
            description: {
                required: "Pesan harus diisi",
                minlength: "Pesan harus minimal 10 karakter"
            },
            phone: {
                number: "Silakan masukkan nomor sebagai nilai numerik"
            }
        }
    });
});
