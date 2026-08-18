<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .ncip-chatbot { position: fixed; right: 24px; bottom: 24px; z-index: 1200; font-family: 'Poppins', 'DM Sans', Arial, sans-serif; }
    .ncip-chatbot-toggle { width: 58px; height: 58px; border: 0; border-radius: 50%; background: #3e7b27; color: #fff; box-shadow: 0 8px 22px rgba(36, 72, 24, 0.28); cursor: pointer; font-size: 1.35rem; }
    .ncip-chatbot-toggle:hover, .ncip-chatbot-toggle:focus-visible { background: #2f641e; outline: 3px solid rgba(62, 123, 39, 0.25); outline-offset: 2px; }
    .ncip-chatbot-panel { display: none; position: absolute; right: 0; bottom: 72px; width: min(360px, calc(100vw - 32px)); height: min(520px, calc(100vh - 112px)); flex-direction: column; overflow: hidden; background: #fff; border: 1px solid #d9e2d5; border-radius: 8px; box-shadow: 0 14px 36px rgba(28, 52, 22, 0.22); }
    .ncip-chatbot.is-open .ncip-chatbot-panel { display: flex; }
    .ncip-chatbot-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; background: #3e7b27; color: #fff; }
    .ncip-chatbot-header strong { display: block; font-size: 0.95rem; letter-spacing: 0; }
    .ncip-chatbot-header small { display: block; margin-top: 2px; font-size: 0.7rem; opacity: 0.88; letter-spacing: 0; }
    .ncip-chatbot-close { border: 0; background: transparent; color: #fff; cursor: pointer; font-size: 1.15rem; padding: 4px; }
    .ncip-chatbot-messages { display: flex; flex: 1; flex-direction: column; gap: 10px; overflow-y: auto; padding: 14px; background: #f8faf7; }
    .ncip-chatbot-message { max-width: 88%; padding: 10px 12px; border-radius: 8px; font-size: 0.8rem; line-height: 1.5; white-space: pre-wrap; overflow-wrap: anywhere; letter-spacing: 0; }
    .ncip-chatbot-message.bot { align-self: flex-start; background: #e8f0e5; color: #243120; }
    .ncip-chatbot-message.user { align-self: flex-end; background: #3e7b27; color: #fff; }
    .ncip-chatbot-form { display: flex; gap: 8px; padding: 12px; border-top: 1px solid #e2e8df; background: #fff; }
    .ncip-chatbot-input { min-width: 0; flex: 1; padding: 10px 11px; border: 1px solid #cbd8c7; border-radius: 6px; font: inherit; font-size: 0.78rem; color: #243120; background: #fff; }
    .ncip-chatbot-input:focus { border-color: #3e7b27; outline: 2px solid rgba(62, 123, 39, 0.15); }
    .ncip-chatbot-send { width: 42px; min-width: 42px; border: 0; border-radius: 6px; background: #3e7b27; color: #fff; cursor: pointer; }
    .ncip-chatbot-send:disabled { cursor: wait; opacity: 0.6; }
    @media (max-width: 480px) {
        .ncip-chatbot { right: 16px; bottom: 16px; }
        .ncip-chatbot-panel { right: -4px; bottom: 68px; width: calc(100vw - 24px); height: min(500px, calc(100vh - 96px)); }
    }
</style>

<div class="ncip-chatbot" id="ncipChatbot">
    <section class="ncip-chatbot-panel" aria-label="NCIP public information assistant" aria-hidden="true">
        <header class="ncip-chatbot-header">
            <div>
                <strong>NCIP Support Assistant</strong>
                <small>Answers from published public information</small>
            </div>
            <button class="ncip-chatbot-close" type="button" aria-label="Close chatbot" title="Close chatbot">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </header>
        <div class="ncip-chatbot-messages" role="log" aria-live="polite" aria-label="Chat messages">
            <div class="ncip-chatbot-message bot">How can I help with NCIP Nueva Ecija's published FAQs and public information?</div>
        </div>
        <form class="ncip-chatbot-form">
            <input class="ncip-chatbot-input" type="text" maxlength="500" autocomplete="off" placeholder="Ask about NCIP public information" aria-label="Your question">
            <button class="ncip-chatbot-send" type="submit" aria-label="Send question" title="Send question">
                <i class="fas fa-paper-plane" aria-hidden="true"></i>
            </button>
        </form>
    </section>
    <button class="ncip-chatbot-toggle" type="button" aria-expanded="false" aria-controls="ncipChatbot" aria-label="Open NCIP support assistant" title="Open support assistant">
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
    const form = chatbot.querySelector('.ncip-chatbot-form');
    const input = chatbot.querySelector('.ncip-chatbot-input');
    const send = chatbot.querySelector('.ncip-chatbot-send');
    const messages = chatbot.querySelector('.ncip-chatbot-messages');
    const fallback = @json("I'm sorry, but I couldn't find an answer to your question in our public information. Please reach out to our support team directly for further assistance.");
    const endpoint = @json(route('website.chat'));
    const csrfToken = @json(csrf_token());

    const addMessage = (text, role) => {
        const message = document.createElement('div');
        message.className = `ncip-chatbot-message ${role}`;
        message.textContent = text;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
        return message;
    };

    const setOpen = (open) => {
        chatbot.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        panel.setAttribute('aria-hidden', String(!open));
        if (open) input.focus();
    };

    toggle.addEventListener('click', () => setOpen(!chatbot.classList.contains('is-open')));
    close.addEventListener('click', () => setOpen(false));
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const question = input.value.trim();
        if (!question || send.disabled) return;

        addMessage(question, 'user');
        input.value = '';
        input.disabled = true;
        send.disabled = true;
        const pending = addMessage('Thinking...', 'bot');

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
            const data = await response.json();
            pending.textContent = data.answer || fallback;
        } catch (error) {
            pending.textContent = fallback;
        } finally {
            input.disabled = false;
            send.disabled = false;
            input.focus();
            messages.scrollTop = messages.scrollHeight;
        }
    });
})();
</script>
