<script>
    document.getElementById('transaction_category').addEventListener('change', function () {
        if (this.value === 'other') {
            document.getElementById('new_transaction_category').style.display = 'block';
        } else {
            document.getElementById('new_transaction_category').style.display = 'none';
        }
    });
</script>