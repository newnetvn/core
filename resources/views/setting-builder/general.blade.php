@input(['name' => 'site_title', 'label' => __('core::setting-builder.general.site_title')])
@mediafile(['name' => 'logo', 'label' => __('core::setting-builder.general.logo'), 'conversion' => ''])
@mediafile(['name' => 'logo_login', 'label' => __('core::setting-builder.general.logo_login'), 'conversion' => ''])
@mediafile(['name' => 'logo_admin', 'label' => __('core::setting-builder.general.logo_admin'), 'conversion' => ''])
@mediafile(['name' => 'favicon', 'label' => __('core::setting-builder.general.favicon'), 'conversion' => ''])
@checkbox(['name' => 'redirect_404_to_home', 'label' => __('core::setting-builder.general.redirect_404_to_home')])
@checkbox([
'name' => 'disable_megamenu',
'label' => __('core::setting-builder.admin.disable_megamenu')
])
