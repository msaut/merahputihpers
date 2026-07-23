{{-- 
    Share Buttons Component
    Uses FontAwesome icons (already loaded in layout) for Facebook, WhatsApp, Copy Link.
    WhatsApp link preview works by crawling OG meta tags via URL only.
--}}
@php
    $shareUrl = $url ?? url()->current();
    $plainUrl = $plainUrl ?? $shareUrl;
    $shareTitle = $title ?? 'MerahPutihPers.com';

    $encodedUrl = urlencode($shareUrl);
    $encodedText = urlencode($shareTitle . ' - ' . $shareUrl);

    // Facebook
    $facebookUrl = "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}";

    // WhatsApp (AUTO DEVICE)
    $whatsappUrl = "https://wa.me/?text={$encodedText}";
@endphp

<div class="share-buttons-wrapper mt-4 mb-4">
    <div class="share-label">
        <i class="fas fa-share-alt"></i> Bagikan
    </div>
    <div class="share-buttons d-flex gap-2 flex-wrap">
        <!-- Facebook (OG crawler reads image + title + description from meta tags) -->
        <a href="{{ $facebookUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-facebook"
           aria-label="Bagikan ke Facebook"
           title="Facebook">
            <span class="share-btn-icon"><i class="fab fa-facebook-f"></i></span>
            <span class="share-btn-text">Facebook</span>
        </a>
        
        <!-- WhatsApp (share only URL → WA crawler shows preview card with image) -->
        <a href="{{ $whatsappUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-whatsapp"
           aria-label="Bagikan ke WhatsApp"
           title="WhatsApp">
            <span class="share-btn-icon"><i class="fab fa-whatsapp"></i></span>
            <span class="share-btn-text">WhatsApp</span>
        </a>
        
        <!-- Copy Link (copies URL only — paste into WA generates rich preview) -->
        <button type="button" 
                class="share-btn share-btn-copy" 
                onclick="copyPlainUrl(this, '{{ $plainUrl }}')"
                aria-label="Salin Link"
                title="Salin Link">
            <span class="share-btn-icon"><i class="fas fa-link"></i></span>
            <span class="share-btn-text">Salin Link</span>
        </button>
    </div>

    <!-- Toast Notification -->
    <div id="copyToast" class="copy-toast">
        <i class="fas fa-check-circle"></i>
        <span>Link berhasil disalin! Tempelkan ke WhatsApp untuk melihat preview.</span>
    </div>
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
        var icon = btn.querySelector('.share-btn-icon i');
        if (icon) {
            icon.style.transform = 'scale(1.3)';
            setTimeout(function() {
                icon.style.transform = '';
                btn.classList.remove('copied');
            }, 2000);
        }
    }
}
</script>
