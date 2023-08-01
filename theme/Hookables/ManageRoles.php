<?php

namespace Theme\Hookables;

use Snap\Core\Hookable;

/**
 * ManageRoles description
 */
class ManageRoles extends Hookable
{
    public function boot(): void
    {
        $this->addFilter('map_meta_cap', 'allowEditorsToManagePrivacyOptions');
    }

    public function allowEditorsToManagePrivacyOptions($caps, $cap, $user_id)
    {
        if (!is_user_logged_in()) {
            return $caps;
        }

        if (in_array($cap, ['export_others_personal_data', 'manage_privacy_options'])) {
            $user_meta = get_userdata($user_id);

            if (array_intersect(['editor', 'administrator'], $user_meta->roles)) {
                $manage_name = is_multisite() ? 'manage_network' : 'manage_options';
                $caps = array_diff($caps, [$manage_name]);
            }
        }

        return $caps;
    }
}
