let conversations = [];
let currentUserId = null;
let selectedUser = null;
let allUsers = [];
let newMessageModal = null;

async function loadConversations() {
    try {
        const response = await fetch('/api/messages');
        const data = await response.json();
        
        if (data.status === 'success') {
            conversations = data.data;
            renderConversationsList();
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Error loading conversations:', error);
        document.getElementById('usersList').innerHTML = '<div class="text-center p-3 text-danger">Erreur de chargement</div>';
    }
}

function renderConversationsList() {
    const usersList = document.getElementById('usersList');
    
    if (conversations.length === 0) {
        usersList.innerHTML = '<div class="text-center p-3 text-muted">Aucune conversation</div>';
        return;
    }
    
    usersList.innerHTML = conversations.map(conv => {
        const photoUrl = (conv.photoProfil && conv.photoProfil.trim() !== '') ? conv.photoProfil : '/assets/images/avatar-placeholder.svg';
        const unreadBadge = conv.unread_count > 0 
            ? `<span class="unread-badge">${conv.unread_count}</span>` 
            : '';
        
        return `
            <a href="#" class="conversation-item ${selectedUser && selectedUser.contact_id === conv.contact_id ? 'active' : ''}" 
                    data-user-id="${conv.contact_id}" 
                    data-username="${conv.username.replace(/"/g, '&quot;')}"
                    data-photo="${conv.photoProfil || ''}">
                <div class="conversation-avatar">
                    <img src="${photoUrl}" alt="${conv.username}">
                </div>
                <div class="conversation-info">
                    <div class="conversation-header">
                        <h6 class="conversation-name">${conv.username}</h6>
                        <span class="conversation-time">${new Date(conv.last_message_time).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}</span>
                    </div>
                    <p class="conversation-preview">${conv.last_message || 'Pas de messages'}</p>
                    <div class="conversation-footer">
                        <span class="conversation-type">User</span>
                        ${unreadBadge}
                    </div>
                </div>
            </a>
        `;
    }).join('');
}

// Filter users based on search
function filterUsers() {
    const searchQuery = document.getElementById('searchUsers').value.toLowerCase();
    const filteredConversations = conversations.filter(conv => 
        conv.username.toLowerCase().includes(searchQuery)
    );
    
    const usersList = document.getElementById('usersList');
    usersList.innerHTML = filteredConversations.map(conv => {
        const photoUrl = (conv.photoProfil && conv.photoProfil.trim() !== '') ? conv.photoProfil : '/assets/images/avatar-placeholder.svg';
        const unreadBadge = conv.unread_count > 0 
            ? `<span class="unread-badge">${conv.unread_count}</span>` 
            : '';
        
        return `
            <a href="#" class="conversation-item ${selectedUser && selectedUser.contact_id === conv.contact_id ? 'active' : ''}" 
                    data-user-id="${conv.contact_id}" 
                    data-username="${conv.username.replace(/"/g, '&quot;')}"
                    data-photo="${conv.photoProfil || ''}">
                <div class="conversation-avatar">
                    <img src="${photoUrl}" alt="${conv.username}">
                </div>
                <div class="conversation-info">
                    <div class="conversation-header">
                        <h6 class="conversation-name">${conv.username}</h6>
                        <span class="conversation-time">${new Date(conv.last_message_time).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}</span>
                    </div>
                    <p class="conversation-preview">${conv.last_message || 'Pas de messages'}</p>
                    <div class="conversation-footer">
                        <span class="conversation-type">User</span>
                        ${unreadBadge}
                    </div>
                </div>
            </a>
        `;
    }).join('');
}

async function selectConversation(userId, username, photoProfil = null) {
    console.log("selected");
    selectedUser = { contact_id: userId, username: username, photoProfil: photoProfil };
    renderConversationsList();
    
    try {
        const response = await fetch(`/api/messages/${userId}`);
        const data = await response.json();
        
        if (data.status === 'success') {
            renderConversation(data.data, username);
            try {
                await fetch(`/api/messages/read/${userId}`);
        
                const conv = conversations.find(c => c.contact_id === userId);
                if (conv) {
                    conv.unread_count = 0;
                    renderConversationsList();
                }
            } catch (readError) {
                console.error('Error marking conversation as read:', readError);
            }
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Error loading conversation:', error);
    }
}

function renderConversation(messages, username) {
    const conversationView = document.getElementById('conversationView');
    const photoUrl = (selectedUser?.photoProfil && selectedUser.photoProfil.trim() !== '') ? selectedUser.photoProfil : '/assets/images/avatar-placeholder.svg';
    const messagePhotoUrl = photoUrl;
    const currentUserId = parseInt(document.body.dataset.currentUserId || '0');
    
    conversationView.innerHTML = `
        <div class="active-chat">
            <div class="chat-header">
                <div class="chat-user-info">
                    <div class="chat-avatar-container">
                        <img src="${photoUrl}" alt="${username}" class="chat-avatar">
                    </div>
                    <div class="chat-details">
                        <h6 class="chat-name">${username}</h6>
                        <p class="chat-status">● Online</p>
                    </div>
                </div>
            </div>
            
            <div class="chat-messages" id="messagesContainer">
                <div class="date-separator">
                    <span class="date-label">Today</span>
                </div>
                
                <div class="message-group">
                    ${messages.map(msg => {
                        const isSent = msg.from_user_id === currentUserId;
                        const time = new Date(msg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                        
                        return `
                            <div class="message ${isSent ? 'own-message' : ''}">
                                ${!isSent ? `<img src="${messagePhotoUrl}" alt="${username}" class="message-avatar">` : ''}
                                <div class="message-bubble">
                                    <div class="message-content">
                                        <p>${msg.message_text}</p>
                                    </div>
                                    <div class="message-info">
                                        <span class="message-time">${time}</span>
                                        ${isSent ? `
                                            <span class="message-status">
                                                <i class="bi ${msg.is_read ? 'bi-check-all' : 'bi-check'}"></i>
                                            </span>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
            
            <div class="chat-input">
                <div class="input-container">
                    <div class="message-input">
                        <form id="messageForm" class="d-flex align-items-center gap-2 w-100">
                            <input type="text" class="form-control" id="messageInput" 
                                    placeholder="Type a message..." required>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Scroll to bottom
    setTimeout(() => {
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }, 100);

    const messageForm = document.getElementById('messageForm');
    if (messageForm) {
        messageForm.addEventListener('submit', sendMessage);
    }
}


async function sendMessage(event) {
    event.preventDefault();
    
    if (!selectedUser) return;
    
    const messageInput = document.getElementById('messageInput');
    const messageText = messageInput.value.trim();
    
    if (!messageText) return;
    
    try {
        const response = await fetch('/api/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                recipientId: selectedUser.contact_id,
                content: messageText
            })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            messageInput.value = '';
            
            selectConversation(selectedUser.contact_id, selectedUser.username);
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Erreur lors de l\'envoi du message');
    }
}

async function loadAllUsers() {
    try {
        const response = await fetch('/api/users/all');
        const data = await response.json();
        
        if (data.status === 'success') {
            allUsers = data.data;
            renderAllUsersList();
        } else {
            document.getElementById('allUsersList').innerHTML = '<div class="text-center p-3 text-danger">Erreur de chargement</div>';
        }
    } catch (error) {
        console.error('Error loading users:', error);
        document.getElementById('allUsersList').innerHTML = '<div class="text-center p-3 text-danger">Erreur de chargement</div>';
    }
}


function renderAllUsersList(filteredUsers = null) {
    const usersList = document.getElementById('allUsersList');
    const usersToRender = filteredUsers || allUsers;
    
    if (usersToRender.length === 0) {
        usersList.innerHTML = '<div class="text-center p-3 text-muted">Aucun utilisateur trouvé</div>';
        return;
    }
    
    usersList.innerHTML = usersToRender.map(user => {
        const photoUrl = (user.photoProfil && user.photoProfil.trim() !== '') ? user.photoProfil : '/assets/images/avatar-placeholder.svg';
        
        return `
            <a href="#" class="conversation-item" 
                    data-user-id="${user.id}" 
                    data-username="${user.username.replace(/"/g, '&quot;')}"
                    data-photo="${user.photoProfil || ''}">
                <div class="conversation-avatar">
                    <img src="${photoUrl}" alt="${user.username}">
                </div>
                <div class="conversation-info">
                    <div class="conversation-header">
                        <h6 class="conversation-name">${user.username}</h6>
                    </div>
                </div>
            </a>
        `;
    }).join('');
}

function filterAllUsers() {
    const searchQuery = document.getElementById('searchAllUsers').value.toLowerCase();
    const filtered = allUsers.filter(user => 
        user.username.toLowerCase().includes(searchQuery)
    );
    renderAllUsersList(filtered);
}


function closeModal(modal){
    if(modal){
        modal.hide();
    }
}

function startNewConversation(userId, username, photoProfil = null) {
    closeModal(newMessageModal);
    selectConversation(userId, username, photoProfil);
}

document.addEventListener('DOMContentLoaded', () => {
    loadConversations();
    
    const modalElement = document.getElementById('newMessageModal');
    if (modalElement && typeof bootstrap !== 'undefined') {
        newMessageModal = new bootstrap.Modal(modalElement);
    }
    
    const refreshBtn = document.getElementById('refreshBtn');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', loadConversations);
    }
    
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
        searchInput.addEventListener('input', filterUsers);
    }
    
    const newMessageBtn = document.getElementById('newMessageBtn');
    if (newMessageBtn) {
        newMessageBtn.addEventListener('click', () => {
            loadAllUsers();
            if (newMessageModal) {
                newMessageModal.show();
            }
        });
    }
    
    const searchAllUsersInput = document.getElementById('searchAllUsers');
    if (searchAllUsersInput) {
        searchAllUsersInput.addEventListener('input', filterAllUsers);
    }
    
    const usersList = document.getElementById('usersList');
    if (usersList) {
        usersList.addEventListener('click', (e) => {
            const userItem = e.target.closest('.conversation-item');
            if (userItem) {
                e.preventDefault();
                const userId = parseInt(userItem.dataset.userId);
                const username = userItem.dataset.username;
                const photoProfil = userItem.dataset.photo;
                selectConversation(userId, username, photoProfil);
            }
        });
    }
    
    const allUsersList = document.getElementById('allUsersList');
    if (allUsersList) {
        allUsersList.addEventListener('click', (e) => {
            const userItem = e.target.closest('.conversation-item');
            if (userItem) {
                const userId = parseInt(userItem.dataset.userId);
                const username = userItem.dataset.username;
                const photoProfil = userItem.dataset.photo;
                startNewConversation(userId, username, photoProfil);
            }
        });
    }
});