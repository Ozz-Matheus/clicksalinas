<div class="buttons-social-media-share">
    <ul class="share-buttons menu">
        {{-- Facebook Share --}}
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrlWithQuery(['utm_source' => 'facebook', 'utm_medium' => 'social_share', 'utm_campaign' => 'user_share'])) }}&amp;title={{ urlencode($description) }}" 
               title="Comparte en Facebook" 
               target="_blank" 
               rel="noopener" 
               class="material-icons">
                <i class="fa fa-facebook-square" aria-hidden="true"></i>
                <span class="sr-only">facebook</span>
            </a>
        </li>

        {{-- Twitter / X Share --}}
        <li>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrlWithQuery(['utm_source' => 'twitter', 'utm_medium' => 'social_share', 'utm_campaign' => 'user_share'])) }}&amp;text={{ urlencode($description) }}&amp;via={{ config('app.name') }}&amp;hashtags={{ config('app.name') }}" 
               target="_blank" 
               title="Tweet" 
               rel="noopener" 
               class="material-icons">
                <i class="fa fa-twitter-square" aria-hidden="true"></i>
                <span class="sr-only">twitter</span>
            </a>
        </li>

        {{-- Pinterest Share --}}
        <li>
            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrlWithQuery(['utm_source' => 'pinterest', 'utm_medium' => 'social_share', 'utm_campaign' => 'user_share'])) }}&amp;description={{ urlencode($description) }}" 
               target="_blank" 
               title="Pin it" 
               rel="noopener" 
               class="material-icons">
                <i class="fa fa-pinterest-square" aria-hidden="true"></i>
                <span class="sr-only">pinterest</span>
            </a>
        </li>
    </ul>

    <div class="section_pt-xsmall click-to-go-back">
        <a href="{{ request()->routeIs('blog.show') ? route('blog.index') : route('portfolio.service', $page->service->slug) }}" class="link-arrow">
            <div class="link-arrow__icon material-icons"> keyboard_arrow_left </div>
            <div class="link-arrow__label">
                Click to go back
            </div>
        </a>
    </div>
</div>