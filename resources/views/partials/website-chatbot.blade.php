<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .ncip-chatbot {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 9999;
        font-family: 'Poppins', 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    .ncip-chatbot-toggle {
        width: 60px;
        height: 60px;
        border: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, #3e7b27 0%, #295b18 100%);
        color: #fff;
        box-shadow: 0 8px 24px rgba(36, 72, 24, 0.35);
        cursor: pointer;
        font-size: 1.45rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
    }
    .ncip-chatbot-toggle:hover {
        transform: scale(1.08);
        box-shadow: 0 12px 28px rgba(36, 72, 24, 0.45);
    }
    .ncip-chatbot-toggle:active {
        transform: scale(0.96);
    }
    .ncip-chatbot-toggle .badge-pulse {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 13px;
        height: 13px;
        background: #10b981;
        border: 2px solid #fff;
        border-radius: 50%;
    }
    .ncip-chatbot-panel {
        display: none;
        position: absolute;
        right: 0;
        bottom: 76px;
        width: min(390px, calc(100vw - 32px));
        height: min(580px, calc(100vh - 110px));
        flex-direction: column;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #d4e3ce;
        border-radius: 16px;
        box-shadow: 0 20px 45px rgba(22, 48, 14, 0.25);
        animation: ncipChatbotFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes ncipChatbotFadeIn {
        from { opacity: 0; transform: translateY(16px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .ncip-chatbot.is-open .ncip-chatbot-panel {
        display: flex;
    }
    .ncip-chatbot-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 14px 18px;
        background: linear-gradient(135deg, #3e7b27 0%, #255415 100%);
        color: #fff;
    }
    .ncip-chatbot-header-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .ncip-chatbot-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .ncip-chatbot-header strong {
        display: block;
        font-size: 0.96rem;
        font-weight: 600;
        letter-spacing: -0.01em;
    }
    .ncip-chatbot-header small {
        display: block;
        margin-top: 2px;
        font-size: 0.72rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .ncip-chatbot-header small .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #34d399;
        display: inline-block;
    }
    .ncip-chatbot-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .ncip-chatbot-header-btn {
        border: 0;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.88rem;
        transition: background 0.18s ease;
    }
    .ncip-chatbot-header-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    .ncip-chatbot-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        overflow: hidden;
        background: #f7faf5;
    }
    .ncip-chatbot-messages {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 12px;
        overflow-y: auto;
        padding: 16px;
        scroll-behavior: smooth;
    }
    .ncip-chatbot-message {
        max-width: 88%;
        padding: 11px 14px;
        border-radius: 14px;
        font-size: 0.83rem;
        line-height: 1.55;
        overflow-wrap: anywhere;
        letter-spacing: -0.005em;
        position: relative;
    }
    .ncip-chatbot-message.bot {
        align-self: flex-start;
        background: #ffffff;
        color: #1f2937;
        border: 1px solid #e1ebdc;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }
    .ncip-chatbot-message.user {
        align-self: flex-end;
        background: #3e7b27;
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 3px 8px rgba(62, 123, 39, 0.25);
    }
    .ncip-chatbot-message p {
        margin: 0 0 8px 0;
    }
    .ncip-chatbot-message p:last-child {
        margin-bottom: 0;
    }
    .ncip-chatbot-message ul, .ncip-chatbot-message ol {
        margin: 6px 0 6px 18px;
        padding: 0;
    }
    .ncip-chatbot-message li {
        margin-bottom: 4px;
    }
    .ncip-chatbot-message strong {
        color: inherit;
        font-weight: 600;
    }
    /* Suggestions Carousel / Quick Chips */
    .ncip-chatbot-suggestions {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding: 8px 14px 10px;
        background: #ffffff;
        border-top: 1px solid #ebf2e8;
        scrollbar-width: thin;
    }
    .ncip-chatbot-chip {
        white-space: nowrap;
        background: #eef6eb;
        border: 1px solid #cbe3c3;
        color: #275618;
        font-size: 0.74rem;
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.18s ease;
        flex-shrink: 0;
    }
    .ncip-chatbot-chip:hover {
        background: #3e7b27;
        color: #ffffff;
        border-color: #3e7b27;
    }
    /* Typing Indicator */
    .ncip-typing {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 10px 14px;
    }
    .ncip-typing span {
        width: 6px;
        height: 6px;
        background: #84a977;
        border-radius: 50%;
        animation: ncipBounce 1.4s infinite ease-in-out both;
    }
    .ncip-typing span:nth-child(1) { animation-delay: -0.32s; }
    .ncip-typing span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes ncipBounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }
    .ncip-chatbot-form {
        display: flex;
        gap: 8px;
        padding: 12px 14px;
        border-top: 1px solid #e3ede0;
        background: #ffffff;
    }
    .ncip-chatbot-input {
        min-width: 0;
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #c9d8c4;
        border-radius: 8px;
        font: inherit;
        font-size: 0.82rem;
        color: #1f2937;
        background: #ffffff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .ncip-chatbot-input:focus {
        border-color: #3e7b27;
        box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.15);
    }
    .ncip-chatbot-send {
        width: 42px;
        min-width: 42px;
        border: 0;
        border-radius: 8px;
        background: #3e7b27;
        color: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        transition: background 0.18s ease, transform 0.1s ease;
    }
    .ncip-chatbot-send:hover {
        background: #2e621b;
    }
    .ncip-chatbot-send:active {
        transform: scale(0.95);
    }
    .ncip-chatbot-send:disabled {
        cursor: not-allowed;
        opacity: 0.55;
    }
    @media (max-width: 480px) {
        .ncip-chatbot { right: 14px; bottom: 14px; }
        .ncip-chatbot-panel {
            right: 0;
            bottom: 70px;
            width: calc(100vw - 28px);
            height: min(540px, calc(100vh - 90px));
        }
    }
</style>

<div class="ncip-chatbot" id="ncipChatbot">
    <section class="ncip-chatbot-panel" aria-label="NCIP public information assistant" aria-hidden="true">
        <header class="ncip-chatbot-header">
            <div class="ncip-chatbot-header-info">
                <div class="ncip-chatbot-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <strong>NCIP Support Assistant</strong>
                    <small><span class="status-dot"></span> Online • Public Info</small>
                </div>
            </div>
            <div class="ncip-chatbot-actions">
                <button class="ncip-chatbot-header-btn ncip-chatbot-reset" type="button" aria-label="Reset chat" title="Reset chat">
                    <i class="fas fa-rotate-right"></i>
                </button>
                <button class="ncip-chatbot-header-btn ncip-chatbot-close" type="button" aria-label="Close chatbot" title="Close chatbot">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </header>

        <div class="ncip-chatbot-body">
            <div class="ncip-chatbot-messages" role="log" aria-live="polite" aria-label="Chat messages">
                <div class="ncip-chatbot-message bot">
                    Hello! 👋 Welcome to the <strong>NCIP Nueva Ecija Support Assistant</strong>.<br><br>
                    How can I assist you today? You can ask questions or tap any topic below:
                </div>
            </div>

            <!-- Quick Suggestion Chips -->
            <div class="ncip-chatbot-suggestions">
                <button class="ncip-chatbot-chip" type="button" data-question="What is COC?">📄 What is COC?</button>
                <button class="ncip-chatbot-chip" type="button" data-question="How to apply for COC online?">📝 How to Apply</button>
                <button class="ncip-chatbot-chip" type="button" data-question="What are the requirements for COC?">📋 Requirements</button>
                <button class="ncip-chatbot-chip" type="button" data-question="Is there a fee for applying COC?">💵 Fees</button>
                <button class="ncip-chatbot-chip" type="button" data-question="Where is the NCIP Nueva Ecija office located?">📍 Office Location</button>
                <button class="ncip-chatbot-chip" type="button" data-question="What are your office hours?">🕒 Office Hours</button>
                <button class="ncip-chatbot-chip" type="button" data-question="What is your contact number and email?">📞 Contact Info</button>
                <button class="ncip-chatbot-chip" type="button" data-question="How to download and submit the Genealogy Form?">🌳 Genealogy Form</button>
            </div>
        </div>

        <form class="ncip-chatbot-form">
            <input class="ncip-chatbot-input" type="text" maxlength="500" autocomplete="off" placeholder="Ask about COC, requirements, office..." aria-label="Your question">
            <button class="ncip-chatbot-send" type="submit" aria-label="Send question" title="Send question">
                <i class="fas fa-paper-plane" aria-hidden="true"></i>
            </button>
        </form>
    </section>

    <button class="ncip-chatbot-toggle" type="button" aria-expanded="false" aria-controls="ncipChatbot" aria-label="Open NCIP support assistant" title="Open NCIP Support Assistant">
        <span class="badge-pulse"></span>
        <i class="fas fa-comment-dots" aria-hidden="true"></i>
    </button>
</div>

<script>
(() => {
    const chatbot = document.getElementById('ncipChatbot');
    if (!chatbot || chatbot.dataset.initialized === 'true') return;
    chatbot.dataset.initialized = 'true';

    const toggle = chatbot.querySelector('.ncip-chatbot-toggle');
    const panel = chatbot.querySelector('.ncip-chatbot-panel');
    const close = chatbot.querySelector('.ncip-chatbot-close');
    const reset = chatbot.querySelector('.ncip-chatbot-reset');
    const form = chatbot.querySelector('.ncip-chatbot-form');
    const input = chatbot.querySelector('.ncip-chatbot-input');
    const send = chatbot.querySelector('.ncip-chatbot-send');
    const messages = chatbot.querySelector('.ncip-chatbot-messages');
    const chips = chatbot.querySelectorAll('.ncip-chatbot-chip');
    
    const fallback = {!! json_encode("I'm sorry, but I couldn't find an answer to your question in our public information. For direct inquiries, you may reach our NCIP Nueva Ecija Provincial Office at (044) 979-2365, mobile +63 912 345 6789, or email ncip.nuevaecija@gmail.com.") !!};
    const endpoint = {!! json_encode(route('website.chat')) !!};
    const csrfToken = {!! json_encode(csrf_token()) !!};

    // Basic Markdown & List Formatter for Rich Formatting
    const formatMessageText = (text) => {
        if (!text) return '';
        
        let html = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Bold **text**
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        // Lists formatting (lines starting with • or - or * or numbers)
        const lines = html.split('\n');
        let inList = false;
        let listType = 'ul';
        let formattedLines = [];

        lines.forEach(line => {
            const trimmed = line.trim();
            const isBullet = /^[•\-\*]\s+(.*)/.test(trimmed);
            const isNumber = /^(\d+)\.\s+(.*)/.test(trimmed);

            if (isBullet) {
                if (!inList || listType !== 'ul') {
                    if (inList) formattedLines.push(`</${listType}>`);
                    formattedLines.push('<ul>');
                    inList = true;
                    listType = 'ul';
                }
                formattedLines.push(`<li>${trimmed.replace(/^[•\-\*]\s+/, '')}</li>`);
            } else if (isNumber) {
                if (!inList || listType !== 'ol') {
                    if (inList) formattedLines.push(`</${listType}>`);
                    formattedLines.push('<ol>');
                    inList = true;
                    listType = 'ol';
                }
                formattedLines.push(`<li>${trimmed.replace(/^\d+\.\s+/, '')}</li>`);
            } else {
                if (inList) {
                    formattedLines.push(`</${listType}>`);
                    inList = false;
                }
                if (trimmed.length > 0) {
                    formattedLines.push(`<p>${line}</p>`);
                }
            }
        });

        if (inList) {
            formattedLines.push(`</${listType}>`);
        }

        return formattedLines.join('');
    };

    const addMessage = (text, role, isHtml = false) => {
        const message = document.createElement('div');
        message.className = `ncip-chatbot-message ${role}`;
        if (isHtml) {
            message.innerHTML = text;
        } else {
            message.innerHTML = formatMessageText(text);
        }
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
        return message;
    };

    const addTypingIndicator = () => {
        const typing = document.createElement('div');
        typing.className = 'ncip-chatbot-message bot ncip-typing';
        typing.innerHTML = '<span></span><span></span><span></span>';
        messages.appendChild(typing);
        messages.scrollTop = messages.scrollHeight;
        return typing;
    };

    const setOpen = (open) => {
        chatbot.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        panel.setAttribute('aria-hidden', String(!open));
        if (open) {
            input.focus();
            messages.scrollTop = messages.scrollHeight;
        }
    };

    const handleSendMessage = async (question) => {
        if (!question || send.disabled) return;

        addMessage(question, 'user');
        input.value = '';
        input.disabled = true;
        send.disabled = true;

        const typingIndicator = addTypingIndicator();

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message: question }),
            });

            if (typingIndicator && typingIndicator.parentNode) {
                typingIndicator.remove();
            }

            if (response.ok) {
                const data = await response.json();
                addMessage(data.answer || fallback, 'bot');
            } else {
                addMessage(fallback, 'bot');
            }
        } catch (error) {
            if (typingIndicator && typingIndicator.parentNode) {
                typingIndicator.remove();
            }
            addMessage(fallback, 'bot');
        } finally {
            input.disabled = false;
            send.disabled = false;
            input.focus();
            messages.scrollTop = messages.scrollHeight;
        }
    };

    toggle.addEventListener('click', () => setOpen(!chatbot.classList.contains('is-open')));
    close.addEventListener('click', () => setOpen(false));

    reset.addEventListener('click', () => {
        messages.innerHTML = `
            <div class="ncip-chatbot-message bot">
                Hello! 👋 Welcome to the <strong>NCIP Nueva Ecija Support Assistant</strong>.<br><br>
                How can I assist you today? You can ask questions or tap any topic below:
            </div>
        `;
    });

    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            const q = chip.getAttribute('data-question');
            if (q) handleSendMessage(q);
        });
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const question = input.value.trim();
        if (question) handleSendMessage(question);
    });
})();
</script>
