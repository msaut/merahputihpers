{{-- 
    Share Buttons Component
    WhatsApp link preview works by crawling OG meta tags via URL only.
    When you send text + URL together, WhatsApp does NOT generate the rich preview card.
    So we send ONLY the URL — WhatsApp crawls it and shows image + title + description automatically.
--}}
@php
    $shareUrl = $url ?? url()->current();
    $shareTitle = $title ?? 'MerahPutihPers.com';

    $encodedUrl = urlencode($shareUrl);

    // Facebook: share URL — FB crawler reads OG tags for preview
    $facebookUrl = "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}";

    // WhatsApp: share ONLY the URL — WA crawler will read OG tags → shows image + title + description
    $whatsappUrl = "https://api.whatsapp.com/send?text={$encodedUrl}";

    // Copy: just the clean URL (pasting into WhatsApp generates preview via OG tags)
    $plainUrl = $shareUrl;
@endphp

<div class="share-buttons-wrapper mt-4 mb-4">
    <div class="share-label">
        <i class="fas fa-share-alt"></i> Bagikan
    </div>
    <div class="share-buttons">
        <!-- Facebook (OG crawler reads image + title + description from meta tags) -->
        <a href="{{ $facebookUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-facebook"
           aria-label="Bagikan ke Facebook"
           title="Facebook">
            <img src="{{ asset('assets/img/news/icon-fb.png') }}" alt="Facebook" loading="lazy">
        </a>
        
        <!-- WhatsApp (share only URL → WA crawler shows preview card with image) -->
        <a href="{{ $whatsappUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-whatsapp"
           aria-label="Bagikan ke WhatsApp"
           title="WhatsApp">
            <img src="{{ asset('assets/img/news/icon-wa.png') }}" alt="WhatsApp" loading="lazy">
        </a>
        
        <!-- Copy Link (copies URL only — paste into WA generates rich preview) -->
        <button type="button" 
                class="share-btn share-btn-copy" 
                onclick="copyPlainUrl(this, '{{ $plainUrl }}')"
                aria-label="Salin Link"
                title="Salin Link">
            <img src="{{ asset('assets/img/news/icon-sl.png') }}" alt="Salin Link" loading="lazy">
        </button>
    </div>

<!-- Toast Notification -->
<div id="copyToast" class="copy-toast">
    <i class="fas fa-check-circle"></i>
    <span>Link berhasil disalin! Tempelkan ke WhatsApp untuk melihat preview.</span>
</div>

<script>
function copyPlainUrl(btn, url) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            showCopyToast(btn);
        }).catch(function() {
            fallbackCopy(btn, url);
        });
    } else {
        fallbackCopy(btn, url);
    }
}

function fallbackCopy(btn, text) {
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
        alert('Salin manual: ' + text);
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
    if (btn) {
        btn.classList.add('copied');
        var img = btn.querySelector('img');
        if (img) {
            img.style.transform = 'scale(1.3)';
            setTimeout(function() {
                img.style.transform = '';
                btn.classList.remove('copied');
            }, 2000);
        }
    }
}
</script>
