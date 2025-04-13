<?php
defined('ABSPATH') || exit;

$prefix = '_simplecv_';

$full_name  = get_post_meta($resume_id, $prefix . 'full_name', true);
$job_title  = get_post_meta($resume_id, $prefix . 'job_title', true);
$summary    = get_post_meta($resume_id, $prefix . 'summary', true);

$contact    = reset(get_post_meta($resume_id, $prefix . 'contact_info', true));
$skills     = get_post_meta($resume_id, $prefix . 'skills', true);
$experience = get_post_meta($resume_id, $prefix . 'experience', true);
$education  = get_post_meta($resume_id, $prefix . 'education', true);
?>

<div class="simplecv-resume" id="<?php echo esc_attr("simplecv-resume-{$resume_id}"); ?>">
    <h1><?php echo esc_html($full_name); ?></h1>
    <h2><?php echo esc_html($job_title); ?></h2>
    <?php if (!empty($contact)): ?>
        <div class="simplecv-resume__contact-info">
            <?php
                $contact = reset(get_post_meta($resume_id, $prefix . 'contact_info', true));
                if (!empty($contact) && is_array($contact)) :
                    $location_parts = [];
                    if (!empty($contact['city'])) {
                        $location_parts[] = esc_html($contact['city']);
                    }
                    if (!empty($contact['country'])) {
                        $location_parts[] = esc_html($contact['country']);
                    }
                    $location = implode(', ', $location_parts);
                ?>
                <div class="simplecv-resume__contact-info-row simplecv-resume__contact-info-basic">
                    <?php if (!empty($location)) : ?>
                        <div class="simplecv-resume__contact-info-location">
                            <span class="simplecv-resume__contact-info-icon simplecv-resume__contact-info-icon-location"></span>
                            <span><?php echo $location; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact['phone'])) : ?>
                        <div class="simplecv-resume__contact-info-phone">
                            <span class="simplecv-resume__contact-info-icon simplecv-resume__contact-info-icon-phone"></span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact['phone'])); ?>">
                                <?php echo esc_html($contact['phone']); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact['email'])) : ?>
                        <div class="simplecv-resume__contact-info-email">
                            <span class="simplecv-resume__contact-info-icon simplecv-resume__contact-info-icon-email"></span>
                            <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                                <?php echo esc_html($contact['email']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="simplecv-resume__contact-info-row simplecv-resume__contact-info-online">
                    <?php if (!empty($contact['website'])) : ?>
                        <div class="simplecv-resume__contact-info-website">
                            <span class="simplecv-resume__contact-info-icon simplecv-resume__contact-info-icon-website"></span>
                            <a target="_blank" href=<?php echo esc_attr($contact['website']); ?>>
                                <?php _e('Website', SIMPLECV_TEXTDOMAIN); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($contact['linkedin'])) : ?>
                        <div class="simplecv-resume__contact-info-linkedin">
                            <span class="simplecv-resume__contact-info-icon simplecv-resume__contact-info-icon-linkedin"></span>
                            <a target="_blank" href=<?php echo esc_attr($contact['linkedin']); ?>>
                                LinkedIn
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
                $networks = get_post_meta($resume_id, $prefix . 'professional_networks', true);
                if (!empty($networks) && is_array($networks)) :
                    $valid_links = array_filter($networks, function ($item) {
                        return !empty($item['platform']) && !empty($item['url']);
                    });
                    if (!empty($valid_links)) :
                ?>
                <div class="simplecv-resume__contact-info-links">
                    <?php foreach ($valid_links as $link): ?>
                        <?php
                            $platform = sanitize_key($link['platform']);
                            $url = esc_url($link['url']);
                            $label = ucfirst($platform);

                            switch ($platform) {
                                case 'github':       $label = 'GitHub'; break;
                                case 'gitlab':       $label = 'GitLab'; break;
                                case 'researchgate': $label = 'ResearchGate'; break;
                                case 'dribbble':     $label = 'Dribbble'; break;
                                case 'behance':      $label = 'Behance'; break;
                                case 'medium':       $label = 'Medium'; break;
                                case 'kaggle':       $label = 'Kaggle'; break;
                                case 'notion':       $label = 'Notion'; break;
                                case 'figma':        $label = 'Figma'; break;
                                case 'linkedin':     $label = 'LinkedIn'; break;
                                case 'other':        $label = __('Portfolio', SIMPLECV_TEXTDOMAIN); break;
                            }
                        ?>
                        <div class="simplecv-resume__contact-info-link simplecv-resume--contact-info-link-<?php echo esc_attr($platform); ?>">
                            <span class="simplecv-resume__contact-info-icon simplecv-resume__contact-info-icon-<?php echo esc_attr($platform); ?>"></span>
                            <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($label); ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
                    endif;
                endif;
                ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($summary)): ?>
        <div class="simplecv-resume__professional-summary">
            <h3><?php esc_html_e('Professional Summary', SIMPLECV_TEXTDOMAIN); ?></h3>
            <?php echo wpautop(wp_kses_post($summary)); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($skills)): ?>
        <div class="simplecv-resume__skills">
            <h3><?php esc_html_e('Skills', SIMPLECV_TEXTDOMAIN); ?></h3>
            <?php foreach ($skills as $skill): ?>
                <div class="simplecv-resume__skill-block">
                    <h4><?php echo esc_html($skill['skill_category']); ?></h4>
                    <p><?php echo esc_html($skill['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($experience)): ?>
        <div class="simplecv-resume__experience">
            <h3><?php esc_html_e('Work Experience', SIMPLECV_TEXTDOMAIN); ?></h3>
            <?php foreach ($experience as $job): ?>
                <div class="simplecv-resume__experience-block">
                    <?php if (!empty($job['company_logo'])): ?>
                        <div class="simplecv-resume__experience-logo">
                            <img src="<?php echo esc_url($job['company_logo']); ?>" alt="<?php echo esc_attr($job['company'] ?? ''); ?>" />
                        </div>
                    <?php endif; ?>
                    <h4 class="simplecv-resume__experience-role"><?php echo esc_html($job['role']); ?></h4>
                    <p class="simplecv-resume__experience-company">
                        <?php if (!empty($job['company_linkedin'])): ?>
                            <a href="<?php echo esc_url($job['company_linkedin']); ?>" target="_blank"><?php echo esc_html($job['company']); ?></a>
                        <?php else: ?>
                            <?php echo esc_html($job['company']); ?>
                        <?php endif; ?>
                    </p>
                    <p class="simplecv-resume__experience-start-end">
                        <?php echo esc_html($job['start_date']); ?> – 
                        <?php echo !empty($job['still_working']) ? esc_html__('Present', SIMPLECV_TEXTDOMAIN) : esc_html($job['end_date']); ?>
                    </p>
                    <?php if (!empty($job['tech_used'])): ?>
                        <p><strong><?php esc_html_e('Technologies:', SIMPLECV_TEXTDOMAIN); ?></strong> <?php echo esc_html($job['tech_used']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($job['key_points'])): ?>
                        <div class="simplecv-resume__experience-contributions">
                            <?php echo wpautop(wp_kses_post($job['key_points'])); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($education)): ?>
        <div class="simplecv-resume__education">
            <h3><?php esc_html_e('Education', SIMPLECV_TEXTDOMAIN); ?></h3>
            <?php foreach ($education as $edu): ?>
                <div class="simplecv-resume__education-block">
                    <?php if (!empty($edu['institute_logo'])): ?>
                        <div class="simplecv-resume__experience-logo">
                            <img src="<?php echo esc_url($edu['institute_logo']); ?>" alt="<?php echo esc_html($edu['institute']); ?>" />
                        </div>
                    <?php endif; ?>
                    <h4><?php echo esc_html($edu['program']); ?></h4>
                    <p class="simplecv-resume__experience-company">
                        <?php if (!empty($edu['institute_linkedin'])): ?>
                            <a href="<?php echo esc_url($edu['institute_linkedin']); ?>" target="_blank"><?php echo esc_html($edu['institute']); ?></a>
                        <?php else: ?>
                            <?php echo esc_html($edu['institute']); ?>
                        <?php endif; ?>
                    </p>
                    <p>
                        <?php echo esc_html($edu['start_date']); ?> – 
                        <?php echo !empty($edu['reading']) ? esc_html__('Present', SIMPLECV_TEXTDOMAIN) : esc_html($edu['end_date']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
