<?php
defined('ABSPATH') || exit;

$resume_id = get_the_ID(); // or pass ID manually to support shortcode later

$prefix = '_simplecv_';

$full_name = get_post_meta($resume_id, $prefix . 'full_name', true);
$job_title = get_post_meta($resume_id, $prefix . 'job_title', true);
$summary   = get_post_meta($resume_id, $prefix . 'summary', true);

$contact   = get_post_meta($resume_id, $prefix . 'contact_info', true);
$skills    = get_post_meta($resume_id, $prefix . 'skills', true);
$experience = get_post_meta($resume_id, $prefix . 'experience', true);
$education  = get_post_meta($resume_id, $prefix . 'education', true);

?>

<div class="resume">
    <h1><?php echo esc_html($full_name); ?></h1>
    <h2><?php echo esc_html($job_title); ?></h2>

    <?php if (!empty($contact)): ?>
        <div class="contact-info">
            <ul>
                <?php if (!empty($contact['phone'])): ?><li><strong>Phone:</strong> <?php echo esc_html($contact['phone']); ?></li><?php endif; ?>
                <?php if (!empty($contact['email'])): ?><li><strong>Email:</strong> <?php echo esc_html($contact['email']); ?></li><?php endif; ?>
                <?php if (!empty($contact['linkedin'])): ?><li><strong>LinkedIn:</strong> <a href="<?php echo esc_url($contact['linkedin']); ?>" target="_blank"><?php echo esc_html($contact['linkedin']); ?></a></li><?php endif; ?>
                <?php if (!empty($contact['github'])): ?><li><strong>GitHub:</strong> <a href="<?php echo esc_url($contact['github']); ?>" target="_blank"><?php echo esc_html($contact['github']); ?></a></li><?php endif; ?>
                <?php if (!empty($contact['website'])): ?><li><strong>Website:</strong> <a href="<?php echo esc_url($contact['website']); ?>" target="_blank"><?php echo esc_html($contact['website']); ?></a></li><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($summary)): ?>
        <div class="summary">
            <h3>Professional Summary</h3>
            <?php echo wpautop(wp_kses_post($summary)); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($skills)): ?>
        <div class="skills">
            <h3>Skills</h3>
            <?php foreach ($skills as $skill): ?>
                <div class="skill-block">
                    <h4><?php echo esc_html($skill['skill_category']); ?></h4>
                    <p><?php echo esc_html($skill['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($experience)): ?>
        <div class="experience">
            <h3>Work Experience</h3>
            <?php foreach ($experience as $job): ?>
                <div class="job-block">
                    <h4><?php echo esc_html($job['role']); ?> at <?php echo esc_html($job['company']); ?></h4>
                    <?php if (!empty($job['company_url'])): ?>
                        <p><a href="<?php echo esc_url($job['company_url']); ?>" target="_blank"><?php echo esc_html($job['company_url']); ?></a></p>
                    <?php endif; ?>
                    <p>
                        <?php echo esc_html($job['start_date']); ?> – 
                        <?php echo !empty($job['still_working']) ? 'Present' : esc_html($job['end_date']); ?>
                    </p>
                    <?php if (!empty($job['tech_used'])): ?>
                        <p><strong>Technologies:</strong> <?php echo esc_html($job['tech_used']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($job['key_points'])): ?>
                        <div class="contributions"><?php echo wpautop(wp_kses_post($job['key_points'])); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($education)): ?>
        <div class="education">
            <h3>Education</h3>
            <?php foreach ($education as $edu): ?>
                <div class="edu-block">
                    <h4><?php echo esc_html($edu['program']); ?> at <?php echo esc_html($edu['institute']); ?></h4>
                    <?php if (!empty($edu['institute_url'])): ?>
                        <p><a href="<?php echo esc_url($edu['institute_url']); ?>" target="_blank"><?php echo esc_html($edu['institute_url']); ?></a></p>
                    <?php endif; ?>
                    <p>
                        <?php echo esc_html($edu['start_date']); ?> – 
                        <?php echo !empty($edu['reading']) ? 'Present' : esc_html($edu['end_date']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
