 @if (categories())
     <div class="col-lg-12 col-md-6">
         <div class="widget">
             <h2 class="section-title mb-3">Categories</h2>
             <div class="widget-body">
                 <ul class="widget-list">
                     @foreach (categories() as $category)
                         <li><a href="{{ route('category_post', $category->slug) }}">{{ Str::ucfirst(words($category->subcategory_name)) }}<span
                                     class="ml-auto">({{ __($category->posts->count()) }})</span></a>
                         </li>
                     @endforeach
                 </ul>
             </div>
         </div>
     </div>
 @endif
