<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Messagerie</title>

    <!-- Bootstrap CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- message.js -->
     <script nonce="<?= $csp_nonce ?>" src="./scripts/components/messages.js"></script>

    <div class="messaging-container">
        <!-- Header -->
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-chat-dots"></i> Messagerie</h4>
                <button class="btn btn-success btn-sm" onclick="refreshMessages()">
                    <i class="bi bi-arrow-clockwise"></i> Rafraîchir
                </button>
            </div>
        </div>

        <!-- Messages Wrapper -->
        <div class="messages-wrapper">
            <!-- Users Sidebar -->
            <div class="users-sidebar">
                <div class="sidebar-header">
                    <input type="search" class="form-control" placeholder="Rechercher..." id="searchUsers">
                </div>
                <div class="users-list" id="usersList">

                    <div class="user-item " onclick="">
                        <div class="user-avatar"></div>
                        <div class="user-info">
                            <div class="user-name">username</div>
                            <div class="user-last-message">last message</div>
                        </div>
                       
                    </div>
                </div>
            </div>

            <!-- Conversation Area -->
            <div class="conversation-area">
                <div id="conversationView">
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="bi bi-chat-dots"></i>
                        <h5>Sélectionnez une conversation</h5>
                        <p class="text-muted">Choisissez un utilisateur pour commencer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script nonce="<?= $csp_nonce ?>">

    </script>



    <!-- Bootstrap JS -->
    <script nonce="<?= $csp_nonce ?>" src="./scripts/js/bootstrap.bundle.min.js"></script>
</body>

</html>