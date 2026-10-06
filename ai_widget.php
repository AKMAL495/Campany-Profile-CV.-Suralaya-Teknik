<!-- Tombol Gelembung Chat AI Melayang di Pojok Kanan Bawah -->
<div id="ai-chat-container" class="fixed bottom-6 right-6 z-50">
    <!-- Tombol Buka/Tutup Chat -->
    <button id="ai-toggle-btn" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-105 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </button>

    <!-- Kotak Jendela Chat -->
    <div id="ai-chat-box" class="hidden absolute bottom-16 right-0 w-80 md:w-96 bg-white rounded-3xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden transition-all duration-300">
        <!-- Header Chat -->
        <div class="bg-gray-900 text-white p-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse"></span>
                <h3 class="font-bold text-sm">Asisten Suralaya Teknik</h3>
            </div>
            <button id="ai-close-btn" class="text-gray-400 hover:text-white text-sm font-bold focus:outline-none">✕</button>
        </div>

        <!-- Ruang Riwayat Percakapan -->
        <div id="ai-chat-messages" class="p-4 h-80 overflow-y-auto space-y-3 bg-gray-50 text-xs">
            <div class="flex items-start">
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 max-w-[80%] text-gray-700">
                    Halo! Ada yang bisa saya bantu seputar layanan AC atau proyek Suralaya Teknik hari ini? 👋
                </div>
            </div>
        </div>

        <!-- Form Input Pesan -->
        <div class="p-3 bg-white border-t border-gray-100 flex items-center space-x-2">
            <input type="text" id="ai-user-input" placeholder="Tulis pesan atau pertanyaan..." class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            <button id="ai-send-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold shadow transition">Kirim</button>
        </div>
    </div>
</div>

<!-- Skrip JavaScript dengan Format Markdown Otomatis -->
<script>
    const toggleBtn = document.getElementById('ai-toggle-btn');
    const closeBtn = document.getElementById('ai-close-btn');
    const chatBox = document.getElementById('ai-chat-box');
    const sendBtn = document.getElementById('ai-send-btn');
    const userInput = document.getElementById('ai-user-input');
    const chatMessages = document.getElementById('ai-chat-messages');

    toggleBtn.addEventListener('click', () => {
        chatBox.classList.toggle('hidden');
        userInput.focus();
    });
    closeBtn.addEventListener('click', () => {
        chatBox.classList.add('hidden');
    });

    async function sendMessage() {
        const text = userInput.value.trim();
        if (!text) return;

        // Tampilkan pesan user
        chatMessages.innerHTML += `
            <div class="flex justify-end">
                <div class="bg-blue-600 text-white p-3 rounded-2xl max-w-[80%] shadow-sm">
                    ${escapeHtml(text)}
                </div>
            </div>
        `;
        userInput.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        const loadingId = 'loading-' + Date.now();
        chatMessages.innerHTML += `
            <div id="${loadingId}" class="flex items-start">
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 text-gray-400 italic">
                    Sedang mengetik...
                </div>
            </div>
        `;
        chatMessages.scrollTop = chatMessages.scrollHeight;

        try {
            const response = await fetch('process_ai.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });
            const data = await response.json();

            document.getElementById(loadingId).remove();
            
            // Format teks balasan AI agar rapi (mengubah **teks** jadi <strong> dan * jadi list)
            const formattedReply = formatMarkdown(data.reply);

            chatMessages.innerHTML += `
                <div class="flex items-start">
                    <div class="bg-white p-3.5 rounded-2xl shadow-sm border border-gray-100 max-w-[85%] text-gray-700 leading-relaxed space-y-1.5">
                        ${formattedReply}
                    </div>
                </div>
            `;
        } catch (error) {
            document.getElementById(loadingId).remove();
            chatMessages.innerHTML += `
                <div class="flex items-start">
                    <div class="bg-red-50 text-red-600 p-3 rounded-2xl max-w-[80%]">
                        Gagal terhubung ke server AI.
                    </div>
                </div>
            `;
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    sendBtn.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    function escapeHtml(text) {
        return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
    }

    // Fungsi untuk merapikan teks markdown dari AI (Bold & Bullet Points)
    function formatMarkdown(text) {
        let safeText = escapeHtml(text);
        
        // Ubah **teks** menjadi cetak tebal (<strong>)
        safeText = safeText.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-gray-900">$1</strong>');
        
        // Ubah tanda * atau - di awal baris menjadi daftar rapi (bullet list)
        safeText = safeText.replace(/[\*\-]\s+/g, '<br>• ');
        
        return safeText;
    }
</script>