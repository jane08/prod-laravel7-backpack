@extends("layouts.main")

@section("meta_title",\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_MAIN))
@section("meta_description",\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_MAIN))
@section("meta_keywords",\App\Models\Seo::getMetaKeywords(\App\Models\MenuItem::PAGE_MAIN))
@section("canonical",\App\Models\Seo::getCanonical(\App\Models\MenuItem::PAGE_MAIN))

@section("og")
    <meta property="og:title" content="{{\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_MAIN)}}" />
    <meta property="og:description" content="{{\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_MAIN)}}" />

    <?php if(!empty(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_MAIN))){
    list($width, $height, $type, $attr) = getimagesize(asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_MAIN)));
    ?>
    <meta property="og:image" content="{{asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_MAIN))}}" />
    <meta property="og:image:width" content="{{$width}}" />
    <meta property="og:image:height" content="{{$height}}" />
    <?php } ?>
@endsection

@section("content")

    Content

@endsection
