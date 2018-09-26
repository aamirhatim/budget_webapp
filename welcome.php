<?php

// Init a session
session_start();

// Check if user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    exit;
} else {
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome!</title>
    </head>

    <body>
        <h1>YOURE LOGGED IN</h1>
        <p><br>Click <a href = 'logout.php'>here</a> to log out.</p>

        <button id="link-button">Link Account</button>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
        <script type="text/javascript">
            (function($) {
            var handler = Plaid.create({
                clientName: 'Plaid Quickstart',
                env: '<%= PLAID_ENV %>',
                key: '<%= PLAID_PUBLIC_KEY %>',
                product: ['transactions'],
                // Optional – use webhooks to get transaction and error updates
                webhook: 'https://requestb.in',
                onLoad: function() {
                // Optional, called when Link loads
                },
                onSuccess: function(public_token, metadata) {
                // Send the public_token to your app server.
                // The metadata object contains info about the institution the
                // user selected and the account ID or IDs, if the
                // Select Account view is enabled.
                $.post('/get_access_token', {
                    public_token: public_token,
                });
                },
                onExit: function(err, metadata) {
                // The user exited the Link flow.
                if (err != null) {
                    // The user encountered a Plaid API error prior to exiting.
                }
                // metadata contains information about the institution
                // that the user selected and the most recent API request IDs.
                // Storing this information can be helpful for support.
                },
                onEvent: function(eventName, metadata) {
                // Optionally capture Link flow events, streamed through
                // this callback as your users connect an Item to Plaid.
                // For example:
                // eventName = "TRANSITION_VIEW"
                // metadata  = {
                //   link_session_id: "123-abc",
                //   mfa_type:        "questions",
                //   timestamp:       "2017-09-14T14:42:19.350Z",
                //   view_name:       "MFA",
                // }
                }
            });

            $('#link-button').on('click', function(e) {
                handler.open();
            });
            })(jQuery);
        </script>
    </body>
</html>