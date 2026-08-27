document.addEventListener('DOMContentLoaded', function() {
    const pdfInput = document.getElementById('pdf');
    const loadingOverlay = document.getElementById('loadingPdf');
    const form = document.getElementById('nidForm');

    function showLoader() {
        loadingOverlay.classList.remove('d-none');
        loadingOverlay.classList.add('d-flex');
    }
    function hideLoader() {
        loadingOverlay.classList.remove('d-flex');
        loadingOverlay.classList.add('d-none');
    }

    pdfInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        showLoader();

        const formData = new FormData();
        formData.append('pdf_file', file);

        axios.post('/dashboard/nid/data', formData)
            .then(async response => {
                hideLoader();

                if (response.data && response.data.status === 'success') {
                    const data = response.data.data.data;
                    const photo = response.data.data.data.photo;
                    const signature = response.data.data.data.signature;

                    form.querySelector('input[name="nid"]').value = data.nid || '';
                    form.querySelector('input[name="pin"]').value = data.pin || '';
                    form.querySelector('input[name="name_bn"]').value = data.nameBn || '';
                    form.querySelector('input[name="name_en"]').value = data.nameEn || '';
                    form.querySelector('input[name="dob"]').value = data.dob || '';
                    form.querySelector('input[name="issue_date"]').value = data.issuedDate ? data.issuedDate.replace(/[০-৯]/g, d => '০১২৩৪৫৬৭৮৯'.indexOf(d)).split('/').reverse().map(v => v.padStart(2,'0')).join('-') : '';
                    form.querySelector('input[name="birth_place"]').value = data.birthPlace || '';
                    form.querySelector('input[name="father_name"]').value = data.fatherName || '';
                    form.querySelector('input[name="mother_name"]').value = data.motherName || '';
                    form.querySelector('input[name="blood_group"]').value = data.bloodGroup || '';
                    form.querySelector('textarea[name="address"]').value = data.fullAddress || '';

                    if (photo) {
                        setInputFromUrl('photoInput', 'photoPreview', photo, 'photo.png');
                    }
                    if (signature) {
                        setInputFromUrl('signatureInput', 'signaturePreview', signature, 'signature.png');
                    }
                }
            })
            .catch(error => {
                hideLoader();
                const res = error.response;

                if (res && res.data) {
                    const { message } = res.data;

                    if (message === 'API request failed: {"status":"error","message":"Insufficient balance.","data":null}') {
                        Swal.fire({
                            icon: 'info',
                            title: 'টোকেন শেষ!',
                            text: 'টোকেন শেষ হয়ে গেছে। দয়া করে অ্যাডমিনের সাথে যোগাযোগ করুন টোকেন পুনঃরায় কিনতে।',
                            confirmButtonText: 'ঠিক আছে'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ত্রুটি!',
                            text: 'নেটওয়ার্ক বা সার্ভার ত্রুটি হয়েছে।',
                            confirmButtonText: 'ঠিক আছে'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ত্রুটি!',
                        text: 'নেটওয়ার্ক বা সার্ভার ত্রুটি হয়েছে।',
                        confirmButtonText: 'ঠিক আছে'
                    });
                }

            });
    });

    function setInputFromUrl(inputId, previewId, url, filename) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (!url) return;
        preview.src = url;

        fetch(url)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], filename, { type: blob.type });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            });
    }

    function setupPreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);
        });
    }

    setupPreview('photoInput', 'photoPreview');
    setupPreview('signatureInput', 'signaturePreview');
});
