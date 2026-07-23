{{-- 
    Share Buttons Component
    Usage: @include('web.partials.share-buttons', ['url' => $url, 'title' => $title, 'image' => $image, 'description' => $description])
--}}
@php
    $shareUrl = $url ?? url()->current();
    $shareTitle = $title ?? 'MerahPutihPers.com';
    $shareImage = $image ?? asset('assets/img/logo/logo.png');
    $shareDescription = $description ?? 'Baca selengkapnya di MerahPutihPers.com';
    
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
           data-tooltip="Bagikan ke Facebook">
            <span class="share-btn-icon">
                <i class="fab fa-facebook-f"></i>
            </span>
            <span class="share-btn-text">Facebook</span>
        </a>
        
        <!-- WhatsApp -->
        <a href="{{ $whatsappUrl }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="share-btn share-btn-whatsapp"
           data-tooltip="Bagikan ke WhatsApp">
            <span class="share-btn-icon">
                <i class="fab fa-whatsapp"></i>
            </span>
            <span class="share-btn-text">WhatsApp</span>
        </a>
        
        <!-- Copy Link -->
        <button type="button" 
                class="share-btn share-btn-copy" 
                onclick="copyShareLink(this, '{{ $shareUrl }}')"
                data-tooltip="Salin Link">
            <span class="share-btn-icon">
                <i class="fas fa-link"></i>
            </span>
            <span class="share-btn-text">Salin Link</span>
        </button>
    </div>
</div>

<!-- Toast Notification for Copy Link -->
<div id="copyToast" class="copy-toast">
    <i class="fas fa-check-circle"></i>
    <span>Link berhasil disalin!</span>
</div>

<script>
function copyShareLink(btn, url) {
    // Fallback for older browsers
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            showCopyToast(btn);
        }).catch(function() {
            fallbackCopyText(btn, url);
        });
    } else {
        fallbackCopyText(btn, url);
    }
}

function fallbackCopyText(btn, url) {
    var textarea = document.createElement('textarea');
    textarea.value = url;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showCopyToast(btn);
    } catch (e) {
        alert('Gagal menyalin link. Silakan salin manual: ' + url);
    }
    document.body.removeChild(textarea);
}

function showCopyToast(btn) {
    var toast = document.getElementById('copyToast');
    if (toast) {
        toast.classList.add('show');
        setTimeout(function() {
            toast.classList.remove('show');
        }, 2500);
    }
    
    // Visual feedback on button
    if (btn) {
        btn.classList.add('copied');
        var textSpan = btn.querySelector('.share-btn-text');
        if (textSpan) {
            var originalText = textSpan.textContent;
            textSpan.textContent = 'Tersalin!';
            setTimeout(function() {
                textSpan.textContent = originalText;
                btn.classList.remove('copied');
            }, 2000);
        }
    }
}
</script>

