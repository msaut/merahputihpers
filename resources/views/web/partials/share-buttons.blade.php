{{-- 
    Share Buttons Component with Rich Content
    Usage: @include('web.partials.share-buttons', [
        'url' => $url, 
        'title' => $title, 
        'description' => $description, 
        'image' => $image
    ])
--}}
@php
    $shareUrl = $url ?? url()->current();
    $shareTitle = $title ?? 'MerahPutihPers.com';
    $shareDescription = $description ?? 'Baca selengkapnya di MerahPutihPers.com';
    
    $encodedUrl = urlencode($shareUrl);
    $encodedTitle = urlencode($shareTitle);
    
    $facebookUrl = "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}";
    
    // WhatsApp rich text: Judul + Deskripsi + Link (agar muncul konten saat di-share)
    $whatsappText = strip_tags($shareTitle) . "\n\n" . strip_tags($shareDescription) . "\n\n" . $shareUrl;
    $encodedWhatsapp = urlencode($whatsappText);
    $whatsappUrl = "https://api.whatsapp.com/send?text={$encodedWhatsapp}";
    
    // Copy rich content: Judul + Deskripsi + Link
    $richCopyText = strip_tags($shareTitle) . "\n\n" . strip_tags($shareDescription) . "\n\n" . $shareUrl;
@endphp

<div class="share-buttons-wrapper mt-4 mb-4">
    <div class="share-label">
        <i class="fas fa-share-alt"></i> Bagikan
    </div>
    <div class="share-buttons">
        <!-- Facebook (OG tags handle thumbnail) -->
        <a href="{{ $facebookUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-facebook"
           aria-label="Bagikan ke Facebook"
           title="Facebook">
            <img src="{{ asset('assets/img/news/icon-fb.png') }}" alt="Facebook" loading="lazy">
        </a>
        
        <!-- WhatsApp (Rich Text: Title + Description + Link) -->
        <a href="{{ $whatsappUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-whatsapp"
           aria-label="Bagikan ke WhatsApp"
           title="WhatsApp">
            <img src="{{ asset('assets/img/news/icon-wa.png') }}" alt="WhatsApp" loading="lazy">
        </a>
        
        <!-- Copy Link (Rich Text: Title + Description + Link) -->
        <button type="button" 
                class="share-btn share-btn-copy" 
                onclick="copyRichContent(this, '{{ addslashes($richCopyText) }}')"
                aria-label="Salin Konten + Link"
                title="Salin Konten + Link">
            <img src="{{ asset('assets/img/news/icon-sl.png') }}" alt="Salin Link" loading="lazy">
        </button>
    </div>

<!-- Toast Notification -->
<div id="copyToast" class="copy-toast">
    <i class="fas fa-check-circle"></i>
    <span>Konten berita berhasil disalin! Siap di-paste ke WhatsApp, Telegram, dll.</span>
</div>

<script>
/**
 * Copy rich content (title + description + URL) to clipboard
 * When pasted to WhatsApp, full content appears
 */
function copyRichContent(btn, richText) {
    if (navigator.clipboard && navigator.clipboard.write) {
        var blob = new Blob([richText], { type: 'text/plain' });
        navigator.clipboard.write([
            new ClipboardItem({ 'text/plain': blob })
        ]).then(function() {
            showCopyToast(btn);
        }).catch(function() {
            fallbackCopyRich(btn, richText);
        });
    } else {
        fallbackCopyRich(btn, richText);
    }
}

function fallbackCopyRich(btn, text) {
    var textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    textarea.style.width = '1px';
    textarea.style.height = '1px';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showCopyToast(btn);
    } catch (e) {
        alert('Tekan Ctrl+C untuk menyalin:\n\n' + text);
    }
    document.body.removeChild(textarea);
}

function showCopyToast(btn) {
    var toast = document.getElementById('copyToast');
    if (toast) {
        toast.classList.add('show');
        setTimeout(function() {
            toast.classList.remove('show');
        }, 3000);
    }
    
    // Visual feedback on the button
    if (btn) {
        btn.classList.add('copied');
        var img = btn.querySelector('img');
        if (img) {
            img.style.transform = 'scale(1.2)';
            setTimeout(function() {
                img.style.transform = '';
                btn.classList.remove('copied');
            }, 2500);
        }
    }
}
</script>
