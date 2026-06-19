<script>
    function setupFileUploadHandler() {
        const defaultAllowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf', 'xls', 'xlsx'];
        const defaultMaxFileSize = 5242880; // 5 MB

        $('.uploader-container input[type="file"]').off('change').on('change', function (event) {
            let $this = $(this);
            let file = $this[0].files[0];

            let allowedExtensions = defaultAllowedExtensions;
            let dataExt = $this.data('allowedExt');
            if (dataExt) {
                allowedExtensions = String(dataExt).split(',').map(function (s) {
                    return s.trim().toLowerCase();
                }).filter(Boolean);
            }

            let maxFileSize = defaultMaxFileSize;
            let maxKb = $this.data('maxKb');
            if (maxKb) {
                maxFileSize = parseInt(maxKb, 10) * 1024;
                if (isNaN(maxFileSize) || maxFileSize < 1024) {
                    maxFileSize = defaultMaxFileSize;
                }
            }

            if (!validateFile(file, allowedExtensions, maxFileSize)) {
                $this.val('');
                return;
            }

            let formdata = new FormData();
            formdata.append('file', file);
            formdata.append('folder', $this.data('folder'));
            let uploadKind = $this.data('uploadKind');
            if (uploadKind) {
                formdata.append('upload_kind', uploadKind);
            }

            let $progressBar = $this.siblings('.progressBar');
            let $status = $this.siblings('.status');

            let $submitButton = $this.closest('body').find('button[type="submit"]');
            $submitButton.prop('disabled', true);

            let ajax = new XMLHttpRequest();

            $progressBar.show();

            ajax.upload.addEventListener('progress', function (event) {
                progressHandler(event, $progressBar, $status);
            }, false);
            ajax.addEventListener('load', function (event) {
                completeHandler(event, $status, $progressBar, $this, $submitButton);
            }, false);
            ajax.addEventListener('error', function (event) {
                errorHandler(event, $status, $submitButton);
            }, false);
            ajax.addEventListener('abort', function (event) {
                abortHandler(event, $status, $submitButton);
            }, false);

            ajax.open('POST', '{{ route('ajax.file-upload') }}');
            ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            ajax.send(formdata);
        });
    }

    function validateFile(file, allowedExtensions, maxFileSize) {
        const fileName = file.name;
        const fileSize = file.size;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            alert('File is not supported');
            return false;
        }

        if (fileSize > maxFileSize) {
            alert('File size is too large.');
            return false;
        }

        return true;
    }

    function progressHandler(event, $progressBar, $status) {
        let percent = (event.loaded / event.total) * 100;
        $progressBar.val(Math.round(percent));
        $status.html(Math.round(percent) + 'Uploading .. %');
    }

    function completeHandler(event, $status, $progressBar, $fileInput, $submitButton) {
        let response = JSON.parse(event.target.responseText);

        if (response.status) {
            $status.html('<span class="text-success">' +
                'File uploaded' +
                '<i class="fa fa-check"></i>' +
                '</span>');
            $progressBar.val(0).hide();

            let originalName = $fileInput.attr('name');
            let baseName = originalName.split('-file')[0];

            let $container = $fileInput.closest('.uploader-container');
            $container.find('input[type="hidden"][name="' + baseName + '"]').remove();

            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = baseName;
            hiddenInput.value = response.path;
            if (/^landing_partner_\d+_logo$/.test(baseName)) {
                hiddenInput.className = 'partner-logo-path';
            }

            $container.append(hiddenInput);
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
            $fileInput.val('');
            $submitButton.prop('disabled', false);
        } else {
            $status.html('<span class="text-danger">' +
                'There is an issue in uploading the file' +
                '<i class="fa fa-exclamation"></i>' +
                '</span>');
            $progressBar.val(0).hide();
            $submitButton.prop('disabled', false);
        }
    }

    function errorHandler(event, $status, $submitButton) {
        $status.html('There is an issue in uploading the file');
        $submitButton.prop('disabled', false);
    }

    function abortHandler(event, $status, $submitButton) {
        $status.html('There is an issue in uploading the file');
        $submitButton.prop('disabled', false);
    }

    window.setupFileUploadHandler = setupFileUploadHandler;

    $(document).ready(function () {
        setupFileUploadHandler();
    });

</script>
