# SimpleCV Classic

🎯 A lightweight WordPress plugin that helps **non-technical professionals** create a polished, structured online resume—powered by CMB2.

---

## 📦 Features

- Custom **Resume** post type (`resume`)
- Structured CMB2-powered fields for:
  - Full name, job title
  - Contact info (phone, email, LinkedIn, etc.)
  - Professional summary
  - Skills (grouped with descriptions)
  - Work experience (repeatable, with date fields and logos)
  - Education (repeatable, with status tracking)
- Easy-to-use `[simplecv_resume id="123"]` shortcode
- Admin UI to copy shortcode with a one-click **Copy** button
- Custom frontend template (`resume-output.php`) for display
- Only loads scripts and styles when needed (e.g. on `resume` post edit page)
- Developer-friendly and extensible

---

## 📥 Installation

> ⚠️ **Please note:**  
> SimpleCV Classic is **exclusively available** via the [official WordPress plugin repository](https://wordpress.org/plugins/).  
> This GitHub repository is for documentation, tracking, and issue reporting only.

### ✅ Requirements

- WordPress 5.8+
- [CMB2 plugin](https://wordpress.org/plugins/cmb2/) (v2.10.1+)

---

## 🧩 Usage

1. Install and activate [CMB2](https://wordpress.org/plugins/cmb2/)
2. Install **SimpleCV Classic** from your WordPress dashboard under **Plugins > Add New**
3. Navigate to **Resumes > Add New**
4. Fill in your details using the structured fields
5. Publish the resume
6. Copy the shortcode from the **“Resume Shortcode”** box:
   ```text
   [simplecv_resume id="123"]
