<!-- JS -->
<script type="text/javascript" src="js/different.js"></script>

<script>
    // Update unreaded messages
    $(document).ready(function() {
        setInterval(function() {
            // Messages
            $("#update_messeges_unreded").load(" #update_messeges_unreded");
            // Notifications
            $("#update_notif_unreded").load(" #update_notif_unreded");
        },5000)
    });
</script>