document.addEventListener('DOMContentLoaded', function () {
    const copyButton = document.getElementById('simplecv-copy-button');
    const input = document.getElementById('simplecv-shortcode');
    const success = document.getElementById('simplecv-copy-success');

    if (copyButton && input && success) {
        copyButton.addEventListener('click', () => {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(input.value)
                    .then(showSuccess)
                    .catch(fallbackCopy);
            } else {
                fallbackCopy();
            }

            function fallbackCopy() {                
                const textarea = document.createElement('textarea');
                textarea.value = input.value;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    showSuccess();
                } catch (err) {
                    alert('Copy failed. Please copy manually.');
                }
                document.body.removeChild(textarea);
            }

            function showSuccess() {
                success.style.display = 'inline';
                setTimeout(() => {
                    success.style.display = 'none';
                }, 1500);
            }
        });
    }
});
