<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Messagerie</title>

    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/icon/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

    <div class="messaging-container">
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">💬 Message</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light btn-sm" id="refreshBtn">
                        🔄 Rafraîchir
                    </button>
                    <a href="/logout" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>


        <div class="messages-wrapper">
            <div class="users-sidebar">
                <div class="sidebar-header">
                    <div class="d-flex gap-2 mb-2">
                        <button class="btn btn-outline-light btn-sm w-100" id="newMessageBtn">
                            <i class="bi bi-plus-circle"></i> Nouveau message
                        </button>
                    </div>
                    <input type="search" class="form-control" placeholder="Rechercher..." id="searchUsers">
                </div>
                <div class="users-list" id="usersList">
                    <div class="text-center p-3">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="conversation-area">
                <div id="conversationView" class="h-100">
                    <div class="empty-state">
                        <i class="bi bi-chat-dots">💬</i>
                        <h5>Sélectionnez une conversation</h5>
                        <p class="text-muted">Choisissez un utilisateur pour commencer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMessageModalLabel">Nouveau message</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="search" class="form-control mb-3" placeholder="Rechercher un utilisateur..." id="searchAllUsers">
                    <div id="allUsersList" class="users-list" style="max-height: 400px; overflow-y: auto;">
                        <div class="text-center p-3">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="<?= $csp_nonce ?>" src="./scripts/js/bootstrap.bundle.min.js"></script>    
    <script nonce="<?= $csp_nonce ?>" src="./scripts/js/my_script.js"></script>
</body>

</html>