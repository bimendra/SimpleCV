<?php
defined('ABSPATH') || exit;

/**
 * Registers CMB2 metaboxes for the Resume post type.
 *
 * Handles fields related to personal details, contact info, skills,
 * work experience, and education.
 *
 * @since 1.0
 */
class SimpleCV_Resume_Metabox {

    /**
     * Prefix for all field IDs to avoid conflicts.
     *
     * @var string
     */
    private $prefix = '_simplecv_';

    /**
     * Constructor. Hooks into the CMB2 admin init action.
     *
     * @since 1.0
     */
    public function __construct() {
        add_action('cmb2_admin_init', [$this, 'register_metabox']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }

    /**
     * Enqueue custom CSS for resume metaboxes on the admin edit screen.
     *
     * @since 1.0
     * @param string $hook The current admin page hook.
     * @return void
     */
    public function enqueue_admin_styles($hook) {
        global $post;
        if ($hook === 'post.php' && $post && $post->post_type === 'resume') {
            wp_enqueue_style(
                'simplecv-admin-resume',
                SIMPLECV_URL . 'css/admin-resume.css',
                [],
                SIMPLECV_VERSION
            );
        }
    }

    /**
     * Register all resume-related metaboxes and groups.
     *
     * @since 1.0
     * @return void
     */
    public function register_metabox() {
        $cmb = new_cmb2_box([
            'id'            => $this->prefix . 'resume_metabox',
            'title'         => __('Resume Details', SIMPLECV_TEXTDOMAIN),
            'object_types'  => ['resume'],
            'context'       => 'normal',
            'priority'      => 'high',
        ]);

        $this->add_basic_fields($cmb);
        $this->add_contact_group($cmb);
        $this->add_summary($cmb);
        $this->add_skills_group($cmb);
        $this->add_experience_group($cmb);
        $this->add_education_group($cmb);
    }

    /**
     * Add basic identity fields like name and job title.
     *
     * @param object $cmb The CMB2 box object.
     * @since 1.0
     */
    private function add_basic_fields($cmb) {
        $cmb->add_field([
            'name' => __('Full Name', SIMPLECV_TEXTDOMAIN),
            'id'   => $this->prefix . 'full_name',
            'type' => 'text',
        ]);

        $cmb->add_field([
            'name' => __('Job Title / Role', SIMPLECV_TEXTDOMAIN),
            'id'   => $this->prefix . 'job_title',
            'type' => 'text',
        ]);
    }

    /**
     * Add contact information group (email, phone, links).
     *
     * @param object $cmb The CMB2 box object.
     * @since 1.0
     */
    private function add_contact_group($cmb) {
        $group = $cmb->add_field([
            'id'          => $this->prefix . 'contact_info',
            'type'        => 'group',
            'description' => __('Enter contact information', SIMPLECV_TEXTDOMAIN),
            'repeatable'  => false,
            'options'     => [
                'group_title'   => __('Contact Info', SIMPLECV_TEXTDOMAIN),
                'add_button'    => false,
                'remove_button' => false,
                'closed'        => false,
            ],
        ]);

        $fields = [
            ['Phone', 'phone', 'text'],
            ['Email', 'email', 'text_email'],
            ['LinkedIn (optional)', 'linkedin', 'text_url'],
            ['GitHub (optional)', 'github', 'text_url'],
            ['Website (optional)', 'website', 'text_url'],
        ];

        foreach ($fields as [$name, $id, $type]) {
            $cmb->add_group_field($group, [
                'name' => $name,
                'id'   => $id,
                'type' => $type,
            ]);
        }
    }

    /**
     * Add professional summary field (WYSIWYG).
     *
     * @param object $cmb The CMB2 box object.
     * @since 1.0
     */
    private function add_summary($cmb) {
        $cmb->add_field([
            'name' => __('Professional Summary', SIMPLECV_TEXTDOMAIN),
            'id'   => $this->prefix . 'summary',
            'type' => 'wysiwyg',
            'options' => [
                'textarea_rows' => 10,
                'media_buttons' => false,
                'teeny'         => true,
            ],
        ]);
    }

    /**
     * Add skills group with category and description.
     *
     * @param object $cmb The CMB2 box object.
     * @since 1.0
     */
    private function add_skills_group($cmb) {
        $group = $cmb->add_field([
            'id'          => $this->prefix . 'skills',
            'type'        => 'group',
            'description' => __('Add multiple skill categories and descriptions', SIMPLECV_TEXTDOMAIN),
            'options'     => [
                'group_title'   => __('Skill Set {#}', SIMPLECV_TEXTDOMAIN),
                'add_button'    => __('Add Another Skill Set', SIMPLECV_TEXTDOMAIN),
                'remove_button' => __('Remove Skill Set', SIMPLECV_TEXTDOMAIN),
                'sortable'      => true,
            ],
        ]);

        $cmb->add_group_field($group, [
            'name' => 'Skill Category (e.g., Frontend, DevOps)',
            'id'   => 'skill_category',
            'type' => 'text',
        ]);

        $cmb->add_group_field($group, [
            'name' => 'Description',
            'id'   => 'description',
            'type' => 'textarea_small',
        ]);
    }

    /**
     * Add work experience group with optional logo, dates, tech used, etc.
     *
     * @param object $cmb The CMB2 box object.
     * @since 1.0
     */
    private function add_experience_group($cmb) {
        $group = $cmb->add_field([
            'id'          => $this->prefix . 'experience',
            'type'        => 'group',
            'description' => __('List previous work experiences', SIMPLECV_TEXTDOMAIN),
            'options'     => [
                'group_title'   => __('Job {#}', SIMPLECV_TEXTDOMAIN),
                'add_button'    => __('Add Another Job', SIMPLECV_TEXTDOMAIN),
                'remove_button' => __('Remove Job', SIMPLECV_TEXTDOMAIN),
                'sortable'      => true,
            ],
        ]);

        $fields = [
            ['Company Name', 'company', 'text'],
            ['LinkedIn URL', 'company_linkedin', 'text_url'],
            ['Company Logo (optional)', 'company_logo', 'file'],
            ['Role', 'role', 'text'],
            ['Still Working Here?', 'still_working', 'checkbox'],
            ['Start Date', 'start_date', 'text_date', 'Y-m-d'],
            ['End Date', 'end_date', 'text_date', 'Y-m-d'],
            ['Company Overview (optional)', 'company_overview', 'textarea_small'],
            ['Technologies Used', 'tech_used', 'text'],
        ];

        foreach ($fields as $field) {
            $args = [
                'name' => $field[0],
                'id'   => $field[1],
                'type' => $field[2],
            ];

            if (isset($field[3])) {
                $args['date_format'] = $field[3];
            }

            if ($field[1] === 'company_logo') {
                $args['options'] = ['url' => false];
                $args['text'] = ['add_upload_file_text' => 'Add logo'];
                $args['query_args'] = ['type' => ['image/jpeg', 'image/png']];
                $args['preview_size'] = 'thumbnail';
            }

            $cmb->add_group_field($group, $args);
        }

        $cmb->add_group_field($group, [
            'name' => 'Key Contributions & Outcomes',
            'id'   => 'key_points',
            'type' => 'wysiwyg',
            'options' => [
                'textarea_rows' => 10,
                'media_buttons' => false,
                'teeny'         => true,
            ],
        ]);
    }

    /**
     * Add education history group with logos, dates, and ongoing status.
     *
     * @param object $cmb The CMB2 box object.
     * @since 1.0
     */
    private function add_education_group($cmb) {
        $group = $cmb->add_field([
            'id'          => $this->prefix . 'education',
            'type'        => 'group',
            'description' => __('List educational qualifications', SIMPLECV_TEXTDOMAIN),
            'options'     => [
                'group_title'   => __('Education {#}', SIMPLECV_TEXTDOMAIN),
                'add_button'    => __('Add Another Education', SIMPLECV_TEXTDOMAIN),
                'remove_button' => __('Remove Education', SIMPLECV_TEXTDOMAIN),
                'sortable'      => true,
            ],
        ]);

        $fields = [
            ['Institute Name', 'institute', 'text'],
            ['LinkedIn', 'institute_linkedin', 'text_url'],
            ['Institute Logo (optional)', 'institute_logo', 'file'],
            ['Program Name', 'program', 'text'],
            ['Currently Reading', 'reading', 'checkbox'],
            ['Start Date', 'start_date', 'text_date', 'Y-m-d'],
            ['End Date', 'end_date', 'text_date', 'Y-m-d'],
        ];

        foreach ($fields as $field) {
            $args = [
                'name' => $field[0],
                'id'   => $field[1],
                'type' => $field[2],
            ];
            if (isset($field[3])) {
                $args['date_format'] = $field[3];
            }

            if ($field[1] === 'institute_logo') {
                $args['options'] = ['url' => false];
                $args['text'] = ['add_upload_file_text' => 'Add logo'];
                $args['query_args'] = ['type' => ['image/jpeg', 'image/png']];
                $args['preview_size'] = 'thumbnail';
            }

            $cmb->add_group_field($group, $args);
        }
    }
}
