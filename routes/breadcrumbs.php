<?php

// Dashboard -> My Sites
Breadcrumbs::for('create_site', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('My Sites', route('dashboard'));
    $trail->push('Create Site', route('dashboard'));
});

// Dashboard > My Ads
Breadcrumbs::for('create_ad', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('My Ads', route('my_ads'));
    $trail->push('Create Ad', route('my_ads'));
});

// Dashboard > My Sites > Edit Site
Breadcrumbs::for('edit_site', function ($trail, $site) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('My Sites', route('dashboard'));
    $trail->push('Edit Site');
    $trail->push($site->title);
});

// Dashboard > My Ads > Edit Ads
Breadcrumbs::for('edit_ad', function ($trail, $ad) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('My Ads', route('my_ads'));
    $trail->push('Edit Ad');
    $trail->push($ad->tittle);
});

/*// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});*/