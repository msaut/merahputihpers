{{-- 
    Share Buttons Component (Icon Only)
    Usage: @include('web.partials.share-buttons', ['url' => $url, 'title' => $title])
--}}
@php
    $shareUrl = $url ?? url()->current();
    $shareTitle = $title ?? 'MerahPutihPers.com';
    
    $encodedUrl = urlencode($shareUrl);
    $encodedTitle = urlencode($shareTitle);
    
    $facebookUrl = "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}";
    $whatsappUrl = "https://api.whatsapp.com/send?text={$encodedTitle}%20-%20{$encodedUrl}";
@endphp

<div class="share-buttons-wrapper mt-4 mb-4">
    <div class="share-label">
        <i class="fas fa-share-alt"></i> Bagikan
    </div>
    <div class="share-buttons">
        <!-- Facebook -->
        <a href="{{ $facebookUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-facebook"
           aria-label="Bagikan ke Facebook"
           title="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        
        <!-- WhatsApp -->
        <a href="{{ $whatsappUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-whatsapp"
           aria-label="Bagikan ke WhatsApp"
           title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        
        <!-- Copy Link -->
        <button type="button" 
                class="share-btn share-btn-copy" 
                onclick="copyShareLink(this, '{{ $shareUrl }}')"
                aria-label="Salin Link"
                title="Salin Link">
            <i class="fas fa-link"></i>
        </button>
    </div>

<!-- Toast Notification for Copy Link -->
<div id="copyToast" class="copy-toast">
    <i class="fas fa-check-circle"></i>
    <span>Link berhasil disalin!</span>
</div>

<script>
function copyShareLink(btn, url) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            showCopyToast();
        }).catch(function() {
            fallbackCopyText(url);
        });
    } else {
        fallbackCopyText(url);
    }
}

function fallbackCopyText(url) {
    var textarea = document.createElement('textarea');
    textarea.value = url;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showCopyToast();
    } catch (e) {
        alert('Gagal menyalin link. Silakan salin manual: ' + url);
    }
    document.body.removeChild(textarea);
}

function showCopyToast() {
    var toast = document.getElementById('copyToast');
    if (toast) {
        toast.classList.add('show');
        setTimeout(function() {
            toast.classList.remove('show');
        }, 2500);
    }
}
</script>
