<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'privacy-policy',
                'title_en' => 'Privacy Policy',
                'title_ta' => 'தனியுரிமை கொள்கை',
                'meta_title' => 'Privacy Policy - Nature Gold',
                'meta_description' => 'Read Nature Gold\'s privacy policy. Learn how we collect, use, and protect your personal information when you shop with us.',
                'content_en' => $this->privacyPolicyEN(),
                'content_ta' => $this->privacyPolicyTA(),
                'is_active' => true,
            ],
            [
                'slug' => 'terms-conditions',
                'title_en' => 'Terms & Conditions',
                'title_ta' => 'விதிமுறைகள் & நிபந்தனைகள்',
                'meta_title' => 'Terms & Conditions - Nature Gold',
                'meta_description' => 'Read Nature Gold\'s terms and conditions for using our website, placing orders, and dealer partnerships.',
                'content_en' => $this->termsEN(),
                'content_ta' => $this->termsTA(),
                'is_active' => true,
            ],
            [
                'slug' => 'refund-policy',
                'title_en' => 'Refund & Return Policy',
                'title_ta' => 'பணத்திரும்ப & திருப்பி அனுப்பும் கொள்கை',
                'meta_title' => 'Refund & Return Policy - Nature Gold',
                'meta_description' => 'Nature Gold\'s refund and return policy. Learn about our hassle-free returns, refund process, and customer satisfaction guarantee.',
                'content_en' => $this->refundPolicyEN(),
                'content_ta' => $this->refundPolicyTA(),
                'is_active' => true,
            ],
            [
                'slug' => 'shipping-policy',
                'title_en' => 'Shipping & Delivery Policy',
                'title_ta' => 'ஷிப்பிங் & டெலிவரி கொள்கை',
                'meta_title' => 'Shipping & Delivery Policy - Nature Gold',
                'meta_description' => 'Nature Gold shipping policy. Free delivery in Tamil Nadu on orders above ₹500. Fast and reliable delivery across India.',
                'content_en' => $this->shippingPolicyEN(),
                'content_ta' => $this->shippingPolicyTA(),
                'is_active' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }

    private function privacyPolicyEN(): string
    {
        return <<<'HTML'
<h2>Introduction</h2>
<p>Nature Gold ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your personal information when you visit our website <strong>naturegold.in</strong>, place an order, or interact with our services.</p>
<p>By using our website, you agree to the collection and use of information in accordance with this policy. If you do not agree with our practices, please do not use our website.</p>

<h2>Information We Collect</h2>

<h3>Personal Information You Provide</h3>
<p>We collect information that you voluntarily provide to us, including:</p>
<ul>
<li><strong>Account Information:</strong> Name, email address, phone number, and password when you create an account</li>
<li><strong>Order Information:</strong> Shipping address, billing address, and payment details when you place an order</li>
<li><strong>Dealer Information:</strong> Business name, GST number, trade license, business type, and territory details when you apply as a dealer</li>
<li><strong>Communication Data:</strong> Messages, inquiries, and feedback you send us via contact forms, email, or WhatsApp</li>
<li><strong>Reviews & Ratings:</strong> Product reviews and ratings you submit</li>
</ul>

<h3>Information Collected Automatically</h3>
<p>When you visit our website, we automatically collect certain information:</p>
<ul>
<li><strong>Device Information:</strong> Browser type, operating system, device type, and screen resolution</li>
<li><strong>Usage Data:</strong> Pages viewed, time spent on pages, click patterns, and navigation paths</li>
<li><strong>Location Data:</strong> Approximate location based on your IP address</li>
<li><strong>Cookies:</strong> Session cookies, preference cookies, and analytics cookies</li>
</ul>

<h2>How We Use Your Information</h2>
<p>We use the collected information for the following purposes:</p>
<ul>
<li><strong>Order Processing:</strong> To process and fulfill your orders, manage payments, and provide delivery updates</li>
<li><strong>Account Management:</strong> To create and manage your account, maintain your order history, and provide customer support</li>
<li><strong>Communication:</strong> To send order confirmations, shipping notifications via WhatsApp, SMS, and email</li>
<li><strong>Improvement:</strong> To improve our website, products, and services based on usage patterns and feedback</li>
<li><strong>Marketing:</strong> To send promotional offers, new product announcements, and newsletters (only with your consent)</li>
<li><strong>Legal Compliance:</strong> To comply with applicable laws, regulations, and legal processes</li>
<li><strong>Fraud Prevention:</strong> To detect and prevent fraudulent transactions and unauthorized access</li>
</ul>

<h2>Information Sharing</h2>
<p>We do not sell your personal information to third parties. We may share your information with:</p>
<ul>
<li><strong>Payment Processors:</strong> Razorpay and PhonePe for processing your payments securely</li>
<li><strong>Delivery Partners:</strong> Shipping and logistics companies to deliver your orders</li>
<li><strong>Communication Services:</strong> WhatsApp Business API, SMS gateways, and email service providers for order notifications</li>
<li><strong>Analytics Providers:</strong> Google Analytics for understanding website usage (anonymized data)</li>
<li><strong>Legal Authorities:</strong> When required by law, court order, or government regulation</li>
</ul>

<h2>Data Security</h2>
<p>We implement industry-standard security measures to protect your personal information:</p>
<ul>
<li>SSL/TLS encryption for all data transmitted between your browser and our servers</li>
<li>Encrypted storage of sensitive data including passwords and payment information</li>
<li>Regular security audits and vulnerability assessments</li>
<li>Access controls limiting employee access to personal data on a need-to-know basis</li>
<li>We do not store your complete credit/debit card numbers — payment processing is handled securely by our payment partners</li>
</ul>

<h2>Cookies</h2>
<p>Our website uses cookies to enhance your browsing experience:</p>
<ul>
<li><strong>Essential Cookies:</strong> Required for the website to function (cart, session, CSRF protection)</li>
<li><strong>Preference Cookies:</strong> Remember your language preference (English/Tamil) and other settings</li>
<li><strong>Analytics Cookies:</strong> Help us understand how visitors use our website</li>
</ul>
<p>You can control cookies through your browser settings. However, disabling essential cookies may affect website functionality.</p>

<h2>Your Rights</h2>
<p>You have the following rights regarding your personal information:</p>
<ul>
<li><strong>Access:</strong> Request a copy of the personal data we hold about you</li>
<li><strong>Correction:</strong> Request correction of any inaccurate or incomplete information</li>
<li><strong>Deletion:</strong> Request deletion of your account and personal data (subject to legal obligations)</li>
<li><strong>Opt-out:</strong> Unsubscribe from marketing communications at any time</li>
<li><strong>Data Portability:</strong> Request your data in a structured, machine-readable format</li>
</ul>
<p>To exercise any of these rights, please contact us at <strong>privacy@naturegold.in</strong> or call us at <strong>+91 98765 43210</strong>.</p>

<h2>Children's Privacy</h2>
<p>Our website is not intended for children under the age of 18. We do not knowingly collect personal information from children. If you believe a child has provided us with personal information, please contact us immediately.</p>

<h2>Third-Party Links</h2>
<p>Our website may contain links to third-party websites. We are not responsible for the privacy practices of these websites. We encourage you to read their privacy policies before providing any personal information.</p>

<h2>Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with the updated date. We encourage you to review this policy periodically.</p>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
<ul>
<li><strong>Email:</strong> privacy@naturegold.in</li>
<li><strong>Phone:</strong> +91 98765 43210</li>
<li><strong>WhatsApp:</strong> +91 98765 43210</li>
<li><strong>Address:</strong> Nature Gold, Tamil Nadu, India</li>
</ul>
HTML;
    }

    private function privacyPolicyTA(): string
    {
        return <<<'HTML'
<h2>அறிமுகம்</h2>
<p>நேச்சர் கோல்ட் ("நாங்கள்", "எங்கள்") உங்கள் தனியுரிமையைப் பாதுகாப்பதில் உறுதிபூண்டுள்ளது. இந்த தனியுரிமை கொள்கை, நீங்கள் எங்கள் இணையதளம் <strong>naturegold.in</strong> ஐ பார்வையிடும் போது, ஆர்டர் செய்யும் போது அல்லது எங்கள் சேவைகளுடன் தொடர்பு கொள்ளும் போது உங்கள் தனிப்பட்ட தகவல்களை நாங்கள் எவ்வாறு சேகரிக்கிறோம், பயன்படுத்துகிறோம், வெளிப்படுத்துகிறோம் மற்றும் பாதுகாக்கிறோம் என்பதை விளக்குகிறது.</p>

<h2>நாங்கள் சேகரிக்கும் தகவல்கள்</h2>

<h3>நீங்கள் வழங்கும் தனிப்பட்ட தகவல்கள்</h3>
<p>நீங்கள் தானாக முன்வந்து வழங்கும் தகவல்களை நாங்கள் சேகரிக்கிறோம்:</p>
<ul>
<li><strong>கணக்கு தகவல்:</strong> கணக்கை உருவாக்கும் போது பெயர், மின்னஞ்சல் முகவரி, தொலைபேசி எண் மற்றும் கடவுச்சொல்</li>
<li><strong>ஆர்டர் தகவல்:</strong> ஆர்டர் செய்யும் போது ஷிப்பிங் முகவரி, பில்லிங் முகவரி மற்றும் பணம் செலுத்தும் விவரங்கள்</li>
<li><strong>டீலர் தகவல்:</strong> வணிக பெயர், GST எண், வர்த்தக உரிமம், வணிக வகை மற்றும் பிரதேச விவரங்கள்</li>
<li><strong>தொடர்பு தரவு:</strong> தொடர்பு படிவங்கள், மின்னஞ்சல் அல்லது WhatsApp வழியாக நீங்கள் அனுப்பும் செய்திகள்</li>
</ul>

<h3>தானாகவே சேகரிக்கப்படும் தகவல்கள்</h3>
<ul>
<li><strong>சாதன தகவல்:</strong> உலாவி வகை, இயக்க முறைமை, சாதன வகை</li>
<li><strong>பயன்பாட்டு தரவு:</strong> பார்வையிட்ட பக்கங்கள், நேரம், கிளிக் முறைகள்</li>
<li><strong>இருப்பிட தரவு:</strong> IP முகவரியின் அடிப்படையிலான தோராயமான இருப்பிடம்</li>
<li><strong>குக்கீகள்:</strong> அமர்வு குக்கீகள், விருப்ப குக்கீகள் மற்றும் பகுப்பாய்வு குக்கீகள்</li>
</ul>

<h2>உங்கள் தகவல்களை நாங்கள் எவ்வாறு பயன்படுத்துகிறோம்</h2>
<ul>
<li><strong>ஆர்டர் செயலாக்கம்:</strong> உங்கள் ஆர்டர்களைச் செயலாக்கவும், பணம் செலுத்துதலை நிர்வகிக்கவும், டெலிவரி புதுப்பிப்புகளை வழங்கவும்</li>
<li><strong>கணக்கு நிர்வாகம்:</strong> உங்கள் கணக்கை உருவாக்கவும் நிர்வகிக்கவும், வாடிக்கையாளர் ஆதரவை வழங்கவும்</li>
<li><strong>தொடர்பு:</strong> WhatsApp, SMS மற்றும் மின்னஞ்சல் வழியாக ஆர்டர் உறுதிப்படுத்தல்கள், ஷிப்பிங் அறிவிப்புகள் அனுப்பவும்</li>
<li><strong>மேம்படுத்தல்:</strong> எங்கள் இணையதளம், தயாரிப்புகள் மற்றும் சேவைகளை மேம்படுத்தவும்</li>
<li><strong>சட்ட இணக்கம்:</strong> பொருந்தக்கூடிய சட்டங்கள் மற்றும் ஒழுங்குமுறைகளுக்கு இணங்கவும்</li>
</ul>

<h2>தகவல் பகிர்வு</h2>
<p>உங்கள் தனிப்பட்ட தகவல்களை நாங்கள் மூன்றாம் தரப்பினருக்கு விற்பனை செய்வதில்லை. பின்வருவோருடன் பகிரலாம்:</p>
<ul>
<li><strong>பணம் செலுத்தும் செயலிகள்:</strong> Razorpay மற்றும் PhonePe</li>
<li><strong>டெலிவரி பார்ட்னர்கள்:</strong> ஷிப்பிங் மற்றும் லாஜிஸ்டிக்ஸ் நிறுவனங்கள்</li>
<li><strong>தொடர்பு சேவைகள்:</strong> WhatsApp Business API, SMS கேட்வே, மின்னஞ்சல் சேவை வழங்குநர்கள்</li>
<li><strong>சட்ட அதிகாரிகள்:</strong> சட்டத்தின்படி தேவைப்படும் போது</li>
</ul>

<h2>தரவு பாதுகாப்பு</h2>
<p>உங்கள் தனிப்பட்ட தகவல்களைப் பாதுகாக்க தொழில்துறை-தரமான பாதுகாப்பு நடவடிக்கைகளை நாங்கள் செயல்படுத்துகிறோம்:</p>
<ul>
<li>SSL/TLS என்க்ரிப்ஷன்</li>
<li>முக்கியமான தரவுகளின் என்க்ரிப்ட் சேமிப்பு</li>
<li>வழக்கமான பாதுகாப்பு தணிக்கைகள்</li>
<li>நாங்கள் முழுமையான கிரெடிட்/டெபிட் கார்டு எண்களை சேமிப்பதில்லை</li>
</ul>

<h2>உங்கள் உரிமைகள்</h2>
<ul>
<li><strong>அணுகல்:</strong> நாங்கள் வைத்திருக்கும் தனிப்பட்ட தரவின் நகலைக் கோருங்கள்</li>
<li><strong>திருத்தம்:</strong> தவறான தகவல்களைத் திருத்தக் கோருங்கள்</li>
<li><strong>நீக்குதல்:</strong> உங்கள் கணக்கு மற்றும் தனிப்பட்ட தரவை நீக்கக் கோருங்கள்</li>
<li><strong>விலகுதல்:</strong> எப்போது வேண்டுமானாலும் சந்தைப்படுத்தல் தொடர்புகளிலிருந்து விலகுங்கள்</li>
</ul>

<h2>தொடர்பு கொள்ளுங்கள்</h2>
<p>இந்த தனியுரிமை கொள்கை குறித்து உங்களுக்கு ஏதேனும் கேள்விகள் இருந்தால், எங்களைத் தொடர்பு கொள்ளுங்கள்:</p>
<ul>
<li><strong>மின்னஞ்சல்:</strong> privacy@naturegold.in</li>
<li><strong>தொலைபேசி:</strong> +91 98765 43210</li>
<li><strong>WhatsApp:</strong> +91 98765 43210</li>
</ul>
HTML;
    }

    private function termsEN(): string
    {
        return <<<'HTML'
<h2>Acceptance of Terms</h2>
<p>By accessing and using the Nature Gold website (<strong>naturegold.in</strong>), you accept and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our website or services.</p>

<h2>Definitions</h2>
<ul>
<li><strong>"Website"</strong> refers to naturegold.in and all its pages</li>
<li><strong>"Products"</strong> refers to cold-pressed oils, food products, and all items available for purchase</li>
<li><strong>"Customer"</strong> refers to any individual or entity purchasing products from our website</li>
<li><strong>"Dealer"</strong> refers to registered business partners who purchase products at wholesale prices</li>
<li><strong>"We/Us/Our"</strong> refers to Nature Gold and its parent company</li>
</ul>

<h2>Account Registration</h2>
<ul>
<li>You must provide accurate and complete information when creating an account</li>
<li>You are responsible for maintaining the confidentiality of your account credentials</li>
<li>You must be at least 18 years old to create an account and place orders</li>
<li>You are responsible for all activities that occur under your account</li>
<li>We reserve the right to suspend or terminate accounts that violate these terms</li>
</ul>

<h2>Products & Pricing</h2>
<ul>
<li>All product descriptions, images, and specifications are as accurate as possible, but we do not guarantee they are error-free</li>
<li>Prices are listed in Indian Rupees (₹) and include applicable GST unless stated otherwise</li>
<li>We reserve the right to change product prices at any time without prior notice</li>
<li>Promotional prices are valid only during the specified promotion period</li>
<li>Product availability is subject to stock and may change without notice</li>
<li>Minor variations in product colour, texture, or packaging are natural and do not constitute a defect</li>
</ul>

<h2>Orders & Payment</h2>
<h3>Placing Orders</h3>
<ul>
<li>By placing an order, you are making an offer to purchase the selected products</li>
<li>An order confirmation does not constitute acceptance; we reserve the right to cancel orders due to pricing errors, stock unavailability, or suspected fraud</li>
<li>We may limit the quantity of products that can be ordered per customer</li>
</ul>

<h3>Payment</h3>
<ul>
<li>We accept payments via Razorpay (UPI, Credit/Debit Cards, Net Banking, Wallets), PhonePe, and Cash on Delivery (COD)</li>
<li>All online payments are processed through secure, PCI-compliant payment gateways</li>
<li>For COD orders, an additional handling charge may apply</li>
<li>If payment fails or is reversed, the order will be cancelled automatically</li>
</ul>

<h2>Shipping & Delivery</h2>
<ul>
<li>We deliver across Tamil Nadu and selected cities in India</li>
<li>Delivery timelines are estimated and not guaranteed</li>
<li>Free delivery is available for orders above ₹500 within Tamil Nadu (terms apply)</li>
<li>Risk of loss passes to the customer upon delivery</li>
<li>Please refer to our <a href="/page/shipping-policy">Shipping Policy</a> for detailed information</li>
</ul>

<h2>Returns & Refunds</h2>
<ul>
<li>Please refer to our <a href="/page/refund-policy">Refund & Return Policy</a> for detailed information on returns, exchanges, and refunds</li>
<li>Perishable food products may have limited return options due to their nature</li>
</ul>

<h2>Dealer Terms</h2>
<h3>Dealer Registration</h3>
<ul>
<li>Dealer registration is subject to approval by Nature Gold</li>
<li>Dealers must provide valid GST registration and business documents</li>
<li>We reserve the right to reject or revoke dealer status at our discretion</li>
</ul>

<h3>Dealer Pricing & Orders</h3>
<ul>
<li>Dealer pricing is confidential and exclusively for approved dealers</li>
<li>Minimum order quantities apply for dealer orders</li>
<li>Dealer prices are not combinable with customer promotions or coupons</li>
<li>Dealers must not resell products below the recommended retail price</li>
</ul>

<h2>Intellectual Property</h2>
<ul>
<li>All content on this website — including logos, brand name, product images, text, graphics, and design — is the property of Nature Gold and is protected by copyright and trademark laws</li>
<li>You may not reproduce, distribute, or use our content without prior written permission</li>
<li>The "Nature Gold" name and logo are registered trademarks</li>
</ul>

<h2>User Conduct</h2>
<p>You agree not to:</p>
<ul>
<li>Use the website for any unlawful purpose</li>
<li>Submit false or misleading information</li>
<li>Attempt to gain unauthorized access to our systems</li>
<li>Interfere with the website's functionality or security</li>
<li>Submit fake reviews or ratings</li>
<li>Use automated tools to scrape or collect data from our website</li>
</ul>

<h2>Limitation of Liability</h2>
<ul>
<li>Nature Gold shall not be liable for any indirect, incidental, or consequential damages arising from the use of our website or products</li>
<li>Our total liability for any claim shall not exceed the amount paid for the specific product or order in question</li>
<li>We are not liable for delays or failures caused by events beyond our control (force majeure)</li>
</ul>

<h2>Indemnification</h2>
<p>You agree to indemnify and hold Nature Gold harmless from any claims, losses, or damages arising from your violation of these terms, your use of the website, or your infringement of any third-party rights.</p>

<h2>Governing Law</h2>
<p>These Terms and Conditions are governed by and construed in accordance with the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Tamil Nadu, India.</p>

<h2>Changes to Terms</h2>
<p>We reserve the right to modify these Terms and Conditions at any time. Changes will be posted on this page with an updated date. Continued use of our website after changes constitutes your acceptance of the revised terms.</p>

<h2>Contact Us</h2>
<p>For questions about these Terms and Conditions, please contact us:</p>
<ul>
<li><strong>Email:</strong> support@naturegold.in</li>
<li><strong>Phone:</strong> +91 98765 43210</li>
<li><strong>WhatsApp:</strong> +91 98765 43210</li>
</ul>
HTML;
    }

    private function termsTA(): string
    {
        return <<<'HTML'
<h2>விதிமுறைகளின் ஒப்புதல்</h2>
<p>நேச்சர் கோல்ட் இணையதளத்தை (<strong>naturegold.in</strong>) அணுகி பயன்படுத்துவதன் மூலம், இந்த விதிமுறைகள் மற்றும் நிபந்தனைகளுக்கு நீங்கள் ஒப்புக்கொள்கிறீர்கள். இந்த விதிமுறைகளுக்கு நீங்கள் உடன்படவில்லை என்றால், எங்கள் இணையதளம் அல்லது சேவைகளைப் பயன்படுத்தாதீர்கள்.</p>

<h2>வரையறைகள்</h2>
<ul>
<li><strong>"இணையதளம்"</strong> என்பது naturegold.in மற்றும் அதன் அனைத்து பக்கங்களையும் குறிக்கிறது</li>
<li><strong>"தயாரிப்புகள்"</strong> என்பது செக்கு எண்ணெய்கள், உணவுப் பொருட்கள் மற்றும் வாங்குவதற்கு கிடைக்கும் அனைத்து பொருட்களையும் குறிக்கிறது</li>
<li><strong>"வாடிக்கையாளர்"</strong> என்பது எங்கள் இணையதளத்தில் இருந்து பொருட்களை வாங்கும் எந்தவொரு நபரையும் குறிக்கிறது</li>
<li><strong>"டீலர்"</strong> என்பது மொத்த விலையில் பொருட்களை வாங்கும் பதிவு செய்யப்பட்ட வணிக கூட்டாளர்களைக் குறிக்கிறது</li>
</ul>

<h2>கணக்கு பதிவு</h2>
<ul>
<li>கணக்கை உருவாக்கும் போது துல்லியமான மற்றும் முழுமையான தகவல்களை நீங்கள் வழங்க வேண்டும்</li>
<li>உங்கள் கணக்கு சான்றுகளின் ரகசியத்தன்மையை நீங்கள் பராமரிக்க வேண்டும்</li>
<li>கணக்கை உருவாக்கவும் ஆர்டர் செய்யவும் நீங்கள் குறைந்தது 18 வயது நிரம்பியவராக இருக்க வேண்டும்</li>
<li>உங்கள் கணக்கின் கீழ் நடக்கும் அனைத்து செயல்பாடுகளுக்கும் நீங்கள் பொறுப்பு</li>
</ul>

<h2>தயாரிப்புகள் & விலை நிர்ணயம்</h2>
<ul>
<li>அனைத்து தயாரிப்பு விவரங்களும் முடிந்தவரை துல்லியமானவை, ஆனால் அவை தவறு-இல்லாதவை என்று நாங்கள் உத்தரவாதம் அளிப்பதில்லை</li>
<li>விலைகள் இந்திய ரூபாயில் (₹) பட்டியலிடப்படுகின்றன மற்றும் பொருந்தக்கூடிய GST உள்ளடக்கியது</li>
<li>முன் அறிவிப்பின்றி எப்போது வேண்டுமானாலும் தயாரிப்பு விலைகளை மாற்ற எங்களுக்கு உரிமை உண்டு</li>
<li>தயாரிப்பு கிடைப்பது சரக்குக்கு உட்பட்டது</li>
</ul>

<h2>ஆர்டர்கள் & பணம் செலுத்துதல்</h2>
<h3>ஆர்டர் செய்தல்</h3>
<ul>
<li>ஆர்டர் செய்வதன் மூலம், தேர்ந்தெடுக்கப்பட்ட தயாரிப்புகளை வாங்க நீங்கள் ஒரு சலுகையை வழங்குகிறீர்கள்</li>
<li>விலை பிழைகள், சரக்கு கிடைக்காமை அல்லது மோசடி சந்தேகம் காரணமாக ஆர்டர்களை ரத்து செய்ய எங்களுக்கு உரிமை உண்டு</li>
</ul>

<h3>பணம் செலுத்துதல்</h3>
<ul>
<li>Razorpay (UPI, கிரெடிட்/டெபிட் கார்டுகள், நெட் பேங்கிங், வாலெட்டுகள்), PhonePe மற்றும் கேஷ் ஆன் டெலிவரி (COD) வழியாக பணம் செலுத்துதல்களை ஏற்கிறோம்</li>
<li>அனைத்து ஆன்லைன் பணம் செலுத்துதல்களும் பாதுகாப்பான பணம் செலுத்தும் நுழைவாயில்கள் மூலம் செயலாக்கப்படுகின்றன</li>
<li>COD ஆர்டர்களுக்கு கூடுதல் கையாளும் கட்டணம் விதிக்கப்படலாம்</li>
</ul>

<h2>ஷிப்பிங் & டெலிவரி</h2>
<ul>
<li>தமிழ்நாடு மற்றும் இந்தியாவின் தேர்ந்தெடுக்கப்பட்ட நகரங்களுக்கு டெலிவரி செய்கிறோம்</li>
<li>டெலிவரி கால அவகாசங்கள் மதிப்பீடு மட்டுமே, உத்தரவாதம் அளிக்கப்படவில்லை</li>
<li>தமிழ்நாட்டிற்குள் ₹500 க்கு மேல் ஆர்டர்களுக்கு இலவச டெலிவரி</li>
</ul>

<h2>டீலர் விதிமுறைகள்</h2>
<ul>
<li>டீலர் பதிவு நேச்சர் கோல்டின் ஒப்புதலுக்கு உட்பட்டது</li>
<li>டீலர்கள் செல்லுபடியாகும் GST பதிவு மற்றும் வணிக ஆவணங்களை வழங்க வேண்டும்</li>
<li>டீலர் விலை ரகசியமானது மற்றும் அங்கீகரிக்கப்பட்ட டீலர்களுக்கு மட்டுமே</li>
<li>டீலர் ஆர்டர்களுக்கு குறைந்தபட்ச ஆர்டர் அளவுகள் பொருந்தும்</li>
</ul>

<h2>அறிவுசார் சொத்து</h2>
<p>இந்த இணையதளத்தில் உள்ள அனைத்து உள்ளடக்கமும் — லோகோக்கள், பிராண்ட் பெயர், தயாரிப்பு படங்கள், உரை, கிராபிக்ஸ் மற்றும் வடிவமைப்பு உள்ளிட்டவை — நேச்சர் கோல்டின் சொத்து மற்றும் பதிப்புரிமை மற்றும் வர்த்தக முத்திரை சட்டங்களால் பாதுகாக்கப்படுகிறது.</p>

<h2>நிர்வாகச் சட்டம்</h2>
<p>இந்த விதிமுறைகள் மற்றும் நிபந்தனைகள் இந்திய சட்டங்களுக்கு இணங்க நிர்வகிக்கப்படுகின்றன. எந்தவொரு தகராறும் தமிழ்நாடு, இந்தியாவின் நீதிமன்றங்களின் பிரத்யேக அதிகார வரம்பிற்கு உட்பட்டதாக இருக்கும்.</p>

<h2>தொடர்பு கொள்ளுங்கள்</h2>
<ul>
<li><strong>மின்னஞ்சல்:</strong> support@naturegold.in</li>
<li><strong>தொலைபேசி:</strong> +91 98765 43210</li>
<li><strong>WhatsApp:</strong> +91 98765 43210</li>
</ul>
HTML;
    }

    private function refundPolicyEN(): string
    {
        return <<<'HTML'
<h2>Our Commitment</h2>
<p>At Nature Gold, customer satisfaction is our top priority. We stand behind the quality of our cold-pressed oils and natural products. If you are not satisfied with your purchase, we are here to help.</p>

<h2>Eligibility for Returns</h2>
<p>You may request a return or refund under the following conditions:</p>

<h3>Eligible for Return/Refund</h3>
<ul>
<li><strong>Damaged Products:</strong> Products received in damaged or broken condition (leaking bottles, dented tins, crushed packaging)</li>
<li><strong>Wrong Product:</strong> Product received is different from what was ordered</li>
<li><strong>Quality Issues:</strong> Product does not meet expected quality standards (unusual odour, discolouration, contamination)</li>
<li><strong>Expired Products:</strong> Products received past their expiry date</li>
<li><strong>Missing Items:</strong> Items listed in the order but not included in the delivery</li>
</ul>

<h3>Not Eligible for Return/Refund</h3>
<ul>
<li>Products with broken or tampered seals (unless received in that condition)</li>
<li>Products used or consumed beyond a reasonable inspection amount</li>
<li>Change of mind after delivery (unless the product is unopened and within 7 days)</li>
<li>Natural colour or viscosity variations in cold-pressed oils (these are normal and not defects)</li>
<li>Products damaged due to improper storage by the customer after delivery</li>
</ul>

<h2>Return Process</h2>
<ol>
<li><strong>Report the Issue (within 48 hours):</strong> Contact us within 48 hours of delivery via:
    <ul>
    <li>WhatsApp: +91 98765 43210</li>
    <li>Email: returns@naturegold.in</li>
    <li>Phone: +91 98765 43210</li>
    </ul>
</li>
<li><strong>Provide Evidence:</strong> Share clear photos/videos of the damaged or incorrect product, including the packaging and shipping label</li>
<li><strong>We'll Review:</strong> Our team will review your request within 24 hours and confirm eligibility</li>
<li><strong>Return Pickup / Replacement:</strong> If approved, we will arrange a free return pickup or send a replacement immediately</li>
<li><strong>Refund Processing:</strong> If a refund is chosen over replacement, it will be processed within 5-7 business days</li>
</ol>

<h2>Refund Methods</h2>
<table>
<thead>
<tr><th>Payment Method</th><th>Refund Method</th><th>Timeline</th></tr>
</thead>
<tbody>
<tr><td>UPI / Wallet</td><td>Refund to original UPI ID / Wallet</td><td>3-5 business days</td></tr>
<tr><td>Credit / Debit Card</td><td>Refund to original card</td><td>5-7 business days</td></tr>
<tr><td>Net Banking</td><td>Refund to original bank account</td><td>5-7 business days</td></tr>
<tr><td>Cash on Delivery</td><td>Bank transfer (NEFT/IMPS)</td><td>5-7 business days</td></tr>
</tbody>
</table>

<h2>Replacement Policy</h2>
<ul>
<li>Replacements are subject to product availability</li>
<li>If the same product is unavailable, you may choose an alternative product of equal value or receive a full refund</li>
<li>Replacement products are delivered within 3-5 business days after approval</li>
<li>No additional shipping charges for replacements</li>
</ul>

<h2>Cancellation Policy</h2>
<h3>Before Shipment</h3>
<ul>
<li>Orders can be cancelled free of charge before they are shipped</li>
<li>To cancel, contact us immediately via WhatsApp or phone</li>
<li>Full refund will be processed within 3-5 business days</li>
</ul>

<h3>After Shipment</h3>
<ul>
<li>Orders that have already been shipped cannot be cancelled</li>
<li>You may refuse delivery (if COD), and the order will be returned to us</li>
<li>For prepaid orders, the refund will be processed after the returned package is received by us</li>
</ul>

<h2>Dealer Returns</h2>
<ul>
<li>Dealer returns are handled separately under dealer-specific terms</li>
<li>Bulk order returns must be reported within 24 hours of delivery</li>
<li>Dealers should contact their assigned relationship manager for return requests</li>
</ul>

<h2>Contact for Returns</h2>
<p>For any return or refund inquiries, please contact us:</p>
<ul>
<li><strong>WhatsApp:</strong> +91 98765 43210 (fastest response)</li>
<li><strong>Email:</strong> returns@naturegold.in</li>
<li><strong>Phone:</strong> +91 98765 43210 (Mon-Sat, 9 AM - 7 PM)</li>
</ul>
HTML;
    }

    private function refundPolicyTA(): string
    {
        return <<<'HTML'
<h2>எங்கள் உறுதிமொழி</h2>
<p>நேச்சர் கோல்டில், வாடிக்கையாளர் திருப்தியே எங்கள் முதன்மை முன்னுரிமை. எங்கள் செக்கு எண்ணெய்கள் மற்றும் இயற்கை தயாரிப்புகளின் தரத்தை நாங்கள் உறுதியளிக்கிறோம். உங்கள் கொள்முதலில் நீங்கள் திருப்தி அடையவில்லை என்றால், நாங்கள் உதவ தயாராக இருக்கிறோம்.</p>

<h2>திருப்பி அனுப்புவதற்கான தகுதி</h2>

<h3>திருப்பி அனுப்ப / பணத்திரும்பப் பெற தகுதியானவை</h3>
<ul>
<li><strong>சேதமடைந்த தயாரிப்புகள்:</strong> சேதமடைந்த அல்லது உடைந்த நிலையில் பெறப்பட்ட தயாரிப்புகள் (கசியும் பாட்டில்கள், நசுக்கப்பட்ட பேக்கேஜிங்)</li>
<li><strong>தவறான தயாரிப்பு:</strong> ஆர்டர் செய்ததை விட வேறுபட்ட தயாரிப்பு பெறப்பட்டது</li>
<li><strong>தர சிக்கல்கள்:</strong> எதிர்பார்த்த தரத்தை பூர்த்தி செய்யாத தயாரிப்பு</li>
<li><strong>காலாவதியான தயாரிப்புகள்:</strong> காலாவதி தேதிக்குப் பிறகு பெறப்பட்ட தயாரிப்புகள்</li>
<li><strong>விடுபட்ட பொருட்கள்:</strong> ஆர்டரில் பட்டியலிடப்பட்ட ஆனால் டெலிவரியில் சேர்க்கப்படாத பொருட்கள்</li>
</ul>

<h3>திருப்பி அனுப்ப தகுதியற்றவை</h3>
<ul>
<li>சீல் உடைக்கப்பட்ட அல்லது சீர்குலைக்கப்பட்ட தயாரிப்புகள் (அந்த நிலையில் பெறப்படாவிட்டால்)</li>
<li>பயன்படுத்தப்பட்ட அல்லது உட்கொள்ளப்பட்ட தயாரிப்புகள்</li>
<li>டெலிவரிக்குப் பிறகு மனம் மாற்றம் (தயாரிப்பு திறக்கப்படாமல் 7 நாட்களுக்குள் இருந்தால் தவிர)</li>
<li>செக்கு எண்ணெய்களில் இயற்கையான நிற அல்லது பாகுத்தன்மை மாறுபாடுகள் (இவை இயல்பானவை)</li>
</ul>

<h2>திருப்பி அனுப்பும் செயல்முறை</h2>
<ol>
<li><strong>சிக்கலைப் புகாரளியுங்கள் (48 மணி நேரத்திற்குள்):</strong> டெலிவரிக்கு 48 மணி நேரத்திற்குள் எங்களைத் தொடர்பு கொள்ளுங்கள்:
    <ul>
    <li>WhatsApp: +91 98765 43210</li>
    <li>மின்னஞ்சல்: returns@naturegold.in</li>
    <li>தொலைபேசி: +91 98765 43210</li>
    </ul>
</li>
<li><strong>ஆதாரம் வழங்குங்கள்:</strong> சேதமடைந்த அல்லது தவறான தயாரிப்பின் தெளிவான புகைப்படங்கள்/வீடியோக்களைப் பகிரவும்</li>
<li><strong>நாங்கள் மதிப்பாய்வு செய்வோம்:</strong> எங்கள் குழு 24 மணி நேரத்திற்குள் உங்கள் கோரிக்கையை மதிப்பாய்வு செய்யும்</li>
<li><strong>திருப்பி எடுப்பு / மாற்றீடு:</strong> அங்கீகரிக்கப்பட்டால், இலவச திருப்பி எடுப்பு ஏற்பாடு செய்வோம் அல்லது உடனடியாக மாற்றீடு அனுப்புவோம்</li>
<li><strong>பணத்திரும்பப் பெறுதல்:</strong> மாற்றீட்டிற்குப் பதிலாக பணத்திரும்பப் பெற விரும்பினால், 5-7 வேலை நாட்களில் செயலாக்கப்படும்</li>
</ol>

<h2>பணத்திரும்ப வழிகள்</h2>
<ul>
<li><strong>UPI / வாலெட்:</strong> அசல் UPI ID / வாலெட்டிற்கு - 3-5 வேலை நாட்கள்</li>
<li><strong>கிரெடிட் / டெபிட் கார்டு:</strong> அசல் கார்டிற்கு - 5-7 வேலை நாட்கள்</li>
<li><strong>நெட் பேங்கிங்:</strong> அசல் வங்கி கணக்கிற்கு - 5-7 வேலை நாட்கள்</li>
<li><strong>கேஷ் ஆன் டெலிவரி:</strong> வங்கி பரிமாற்றம் (NEFT/IMPS) - 5-7 வேலை நாட்கள்</li>
</ul>

<h2>மாற்றீட்டு கொள்கை</h2>
<ul>
<li>மாற்றீடுகள் தயாரிப்பு கிடைப்பதற்கு உட்பட்டது</li>
<li>அதே தயாரிப்பு கிடைக்கவில்லை என்றால், சம மதிப்புள்ள மாற்று தயாரிப்பைத் தேர்வு செய்யலாம் அல்லது முழு பணத்திரும்பப் பெறலாம்</li>
<li>மாற்றீட்டு தயாரிப்புகள் அங்கீகரிப்புக்குப் பிறகு 3-5 வேலை நாட்களில் டெலிவரி செய்யப்படும்</li>
</ul>

<h2>ரத்து கொள்கை</h2>
<h3>ஷிப்பிங்கிற்கு முன்</h3>
<ul>
<li>ஆர்டர்கள் அனுப்பப்படுவதற்கு முன் இலவசமாக ரத்து செய்யலாம்</li>
<li>ரத்து செய்ய, WhatsApp அல்லது தொலைபேசி வழியாக உடனடியாக எங்களைத் தொடர்பு கொள்ளுங்கள்</li>
<li>முழு பணத்திரும்ப 3-5 வேலை நாட்களில் செயலாக்கப்படும்</li>
</ul>

<h3>ஷிப்பிங்கிற்குப் பிறகு</h3>
<ul>
<li>ஏற்கனவே அனுப்பப்பட்ட ஆர்டர்களை ரத்து செய்ய இயலாது</li>
<li>COD ஆர்டர்களுக்கு, டெலிவரியை நிராகரிக்கலாம்</li>
<li>முன்பணம் செலுத்திய ஆர்டர்களுக்கு, திருப்பி அனுப்பப்பட்ட பொட்டலம் எங்களுக்கு வந்தடைந்த பிறகு பணத்திரும்ப செயலாக்கப்படும்</li>
</ul>

<h2>தொடர்பு கொள்ளுங்கள்</h2>
<ul>
<li><strong>WhatsApp:</strong> +91 98765 43210 (விரைவான பதில்)</li>
<li><strong>மின்னஞ்சல்:</strong> returns@naturegold.in</li>
<li><strong>தொலைபேசி:</strong> +91 98765 43210 (திங்கள்-சனி, காலை 9 - மாலை 7)</li>
</ul>
HTML;
    }

    private function shippingPolicyEN(): string
    {
        return <<<'HTML'
<h2>Delivery Coverage</h2>
<p>Nature Gold delivers across Tamil Nadu and major cities in India. We are committed to bringing our fresh, cold-pressed oils and natural products to your doorstep quickly and safely.</p>

<h3>Tamil Nadu (Primary Service Area)</h3>
<p>We cover <strong>all 38 districts</strong> of Tamil Nadu with the fastest delivery times and lowest shipping rates.</p>

<h3>Rest of India</h3>
<p>We ship to all major cities and towns across India through our logistics partners.</p>

<h2>Shipping Charges</h2>
<table>
<thead>
<tr><th>Zone</th><th>Order Value</th><th>Shipping Charge</th></tr>
</thead>
<tbody>
<tr><td>Chennai Metro (Chennai, Chengalpattu, Tiruvallur, Kancheepuram)</td><td>Above ₹300</td><td><strong>FREE</strong></td></tr>
<tr><td>Chennai Metro</td><td>Below ₹300</td><td>₹40</td></tr>
<tr><td>Tamil Nadu (Other Districts)</td><td>Above ₹500</td><td><strong>FREE</strong></td></tr>
<tr><td>Tamil Nadu (Other Districts)</td><td>Below ₹500</td><td>₹60</td></tr>
<tr><td>Rest of India (Major Cities)</td><td>Above ₹1,000</td><td><strong>FREE</strong></td></tr>
<tr><td>Rest of India (Major Cities)</td><td>Below ₹1,000</td><td>₹99</td></tr>
<tr><td>Rest of India (Remote Areas)</td><td>All orders</td><td>₹149</td></tr>
</tbody>
</table>
<p><em>Note: Shipping charges may vary based on order weight and delivery location. Exact charges are calculated at checkout.</em></p>

<h2>Estimated Delivery Times</h2>
<table>
<thead>
<tr><th>Zone</th><th>Estimated Delivery</th></tr>
</thead>
<tbody>
<tr><td>Chennai Metro</td><td>1-2 business days</td></tr>
<tr><td>Major Tamil Nadu Cities (Coimbatore, Madurai, Tiruchirappalli, Salem)</td><td>2-3 business days</td></tr>
<tr><td>Other Tamil Nadu Districts</td><td>3-5 business days</td></tr>
<tr><td>South India (Kerala, Karnataka, Andhra Pradesh, Telangana)</td><td>4-6 business days</td></tr>
<tr><td>Rest of India</td><td>5-8 business days</td></tr>
</tbody>
</table>
<p><em>Note: Delivery times are estimates and may vary due to weather, holidays, or logistical factors. Business days exclude Sundays and public holidays.</em></p>

<h2>Order Processing</h2>
<ul>
<li><strong>Processing Time:</strong> Orders are processed within 24 hours of placement (excluding Sundays and holidays)</li>
<li><strong>Order Confirmation:</strong> You will receive an order confirmation via WhatsApp and email immediately after placing the order</li>
<li><strong>Dispatch Notification:</strong> Once your order is dispatched, you will receive a shipping confirmation with tracking details via WhatsApp and SMS</li>
<li><strong>Cut-off Time:</strong> Orders placed before 2 PM are typically processed the same day; orders placed after 2 PM are processed the next business day</li>
</ul>

<h2>Order Tracking</h2>
<p>You can track your order through the following methods:</p>
<ul>
<li><strong>My Account:</strong> Log in to your account and view order status under "My Orders"</li>
<li><strong>WhatsApp Updates:</strong> Real-time shipping updates sent to your WhatsApp number</li>
<li><strong>SMS:</strong> Tracking updates sent via SMS</li>
<li><strong>Contact Us:</strong> Call or WhatsApp us with your order number for immediate status</li>
</ul>

<h2>Packaging</h2>
<p>We take extra care in packaging to ensure your products arrive safely:</p>
<ul>
<li>Oil bottles are securely wrapped with bubble wrap and placed in sturdy corrugated boxes</li>
<li>Tins are packed with protective padding to prevent dents</li>
<li>All packages include a packing slip with order details</li>
<li>We use food-grade packaging materials that are safe and eco-friendly</li>
<li>Fragile labels are applied to all packages containing glass bottles</li>
</ul>

<h2>Delivery Instructions</h2>
<ul>
<li>Please ensure someone is available at the delivery address to receive the package</li>
<li>If no one is available, the delivery partner may attempt redelivery or leave the package at a safe location</li>
<li>For apartment complexes, please provide clear apartment/flat numbers and any entry instructions</li>
<li>Please inspect the package at the time of delivery and report any visible damage to the delivery person</li>
</ul>

<h2>Cash on Delivery (COD)</h2>
<ul>
<li>COD is available for orders up to ₹5,000</li>
<li>An additional COD handling charge of ₹30 may apply</li>
<li>Please keep the exact change ready for COD orders</li>
<li>COD is not available for certain remote locations</li>
</ul>

<h2>Dealer / Bulk Orders</h2>
<ul>
<li>Dealers and bulk orders may have different shipping arrangements</li>
<li>Bulk orders above ₹5,000 enjoy free shipping across Tamil Nadu</li>
<li>For very large orders, we arrange direct dispatch from our production facility</li>
<li>Dealer shipping queries should be directed to your assigned relationship manager</li>
</ul>

<h2>Issues & Support</h2>
<p>If you experience any issues with delivery, please contact us immediately:</p>
<ul>
<li><strong>WhatsApp:</strong> +91 98765 43210 (fastest response)</li>
<li><strong>Email:</strong> shipping@naturegold.in</li>
<li><strong>Phone:</strong> +91 98765 43210 (Mon-Sat, 9 AM - 7 PM)</li>
</ul>
HTML;
    }

    private function shippingPolicyTA(): string
    {
        return <<<'HTML'
<h2>டெலிவரி பகுதிகள்</h2>
<p>நேச்சர் கோல்ட் தமிழ்நாடு முழுவதும் மற்றும் இந்தியாவின் முக்கிய நகரங்களுக்கு டெலிவரி செய்கிறது. புதிய, செக்கு எண்ணெய்கள் மற்றும் இயற்கை பொருட்களை உங்கள் வீட்டு வாசலில் விரைவாகவும் பாதுகாப்பாகவும் கொண்டு வர நாங்கள் உறுதிபூண்டுள்ளோம்.</p>

<h3>தமிழ்நாடு (முதன்மை சேவை பகுதி)</h3>
<p>தமிழ்நாட்டின் <strong>அனைத்து 38 மாவட்டங்களையும்</strong> மிக விரைவான டெலிவரி நேரங்கள் மற்றும் குறைந்த ஷிப்பிங் கட்டணங்களுடன் உள்ளடக்குகிறோம்.</p>

<h3>இந்தியாவின் பிற பகுதிகள்</h3>
<p>எங்கள் லாஜிஸ்டிக்ஸ் கூட்டாளர்கள் மூலம் இந்தியா முழுவதும் அனைத்து முக்கிய நகரங்கள் மற்றும் நகரங்களுக்கு ஷிப் செய்கிறோம்.</p>

<h2>ஷிப்பிங் கட்டணங்கள்</h2>
<ul>
<li><strong>சென்னை மெட்ரோ:</strong> ₹300 க்கு மேல் - <strong>இலவசம்</strong> | ₹300 க்கு கீழ் - ₹40</li>
<li><strong>தமிழ்நாடு (பிற மாவட்டங்கள்):</strong> ₹500 க்கு மேல் - <strong>இலவசம்</strong> | ₹500 க்கு கீழ் - ₹60</li>
<li><strong>இந்தியாவின் பிற பகுதிகள் (முக்கிய நகரங்கள்):</strong> ₹1,000 க்கு மேல் - <strong>இலவசம்</strong> | ₹1,000 க்கு கீழ் - ₹99</li>
<li><strong>இந்தியாவின் பிற பகுதிகள் (தொலைவான பகுதிகள்):</strong> அனைத்து ஆர்டர்கள் - ₹149</li>
</ul>
<p><em>குறிப்பு: ஆர்டர் எடை மற்றும் டெலிவரி இடத்தின் அடிப்படையில் ஷிப்பிங் கட்டணங்கள் மாறுபடலாம். சரியான கட்டணங்கள் செக்அவுட் நேரத்தில் கணக்கிடப்படும்.</em></p>

<h2>மதிப்பிடப்பட்ட டெலிவரி நேரங்கள்</h2>
<ul>
<li><strong>சென்னை மெட்ரோ:</strong> 1-2 வேலை நாட்கள்</li>
<li><strong>முக்கிய தமிழ்நாடு நகரங்கள்:</strong> 2-3 வேலை நாட்கள்</li>
<li><strong>பிற தமிழ்நாடு மாவட்டங்கள்:</strong> 3-5 வேலை நாட்கள்</li>
<li><strong>தென்னிந்தியா:</strong> 4-6 வேலை நாட்கள்</li>
<li><strong>இந்தியாவின் பிற பகுதிகள்:</strong> 5-8 வேலை நாட்கள்</li>
</ul>
<p><em>குறிப்பு: டெலிவரி நேரங்கள் மதிப்பீடுகள் மட்டுமே. வானிலை, விடுமுறை நாட்கள் அல்லது லாஜிஸ்டிக் காரணிகளால் மாறுபடலாம்.</em></p>

<h2>ஆர்டர் செயலாக்கம்</h2>
<ul>
<li><strong>செயலாக்க நேரம்:</strong> ஆர்டர்கள் 24 மணி நேரத்திற்குள் செயலாக்கப்படும் (ஞாயிறு மற்றும் விடுமுறை நாட்கள் தவிர)</li>
<li><strong>ஆர்டர் உறுதிப்படுத்தல்:</strong> ஆர்டர் செய்த உடனேயே WhatsApp மற்றும் மின்னஞ்சல் வழியாக உறுதிப்படுத்தல் பெறுவீர்கள்</li>
<li><strong>அனுப்புதல் அறிவிப்பு:</strong> உங்கள் ஆர்டர் அனுப்பப்பட்டவுடன், ட்ராக்கிங் விவரங்களுடன் WhatsApp மற்றும் SMS வழியாக ஷிப்பிங் உறுதிப்படுத்தல் பெறுவீர்கள்</li>
<li><strong>கட்-ஆஃப் நேரம்:</strong> மதியம் 2 மணிக்கு முன் செய்யப்படும் ஆர்டர்கள் அதே நாள் செயலாக்கப்படும்</li>
</ul>

<h2>ஆர்டர் ட்ராக்கிங்</h2>
<ul>
<li><strong>எனது கணக்கு:</strong> உங்கள் கணக்கில் உள்நுழைந்து "எனது ஆர்டர்கள்" இல் ஆர்டர் நிலையைக் காணலாம்</li>
<li><strong>WhatsApp புதுப்பிப்புகள்:</strong> உங்கள் WhatsApp எண்ணுக்கு நிகழ்நேர ஷிப்பிங் புதுப்பிப்புகள்</li>
<li><strong>SMS:</strong> SMS வழியாக ட்ராக்கிங் புதுப்பிப்புகள்</li>
</ul>

<h2>பேக்கேஜிங்</h2>
<ul>
<li>எண்ணெய் பாட்டில்கள் பபுள் ராப் மற்றும் உறுதியான அட்டைப் பெட்டிகளில் பாதுகாப்பாக பேக் செய்யப்படுகின்றன</li>
<li>டின்கள் பாதுகாப்பு பேடிங்குடன் பேக் செய்யப்படுகின்றன</li>
<li>அனைத்து பொட்டலங்களிலும் ஆர்டர் விவரங்களுடன் பேக்கிங் ஸ்லிப் அடங்கும்</li>
<li>உணவு-தர பேக்கேஜிங் பொருட்களைப் பயன்படுத்துகிறோம்</li>
</ul>

<h2>கேஷ் ஆன் டெலிவரி (COD)</h2>
<ul>
<li>₹5,000 வரையிலான ஆர்டர்களுக்கு COD கிடைக்கும்</li>
<li>₹30 கூடுதல் COD கையாளும் கட்டணம் விதிக்கப்படலாம்</li>
<li>COD ஆர்டர்களுக்கு சரியான தொகையை தயாராக வைத்திருங்கள்</li>
</ul>

<h2>டீலர் / மொத்த ஆர்டர்கள்</h2>
<ul>
<li>₹5,000 க்கு மேல் மொத்த ஆர்டர்களுக்கு தமிழ்நாடு முழுவதும் இலவச ஷிப்பிங்</li>
<li>மிகப் பெரிய ஆர்டர்களுக்கு, எங்கள் உற்பத்தி வசதியிலிருந்து நேரடி அனுப்புதல் ஏற்பாடு செய்கிறோம்</li>
</ul>

<h2>தொடர்பு & ஆதரவு</h2>
<ul>
<li><strong>WhatsApp:</strong> +91 98765 43210 (விரைவான பதில்)</li>
<li><strong>மின்னஞ்சல்:</strong> shipping@naturegold.in</li>
<li><strong>தொலைபேசி:</strong> +91 98765 43210 (திங்கள்-சனி, காலை 9 - மாலை 7)</li>
</ul>
HTML;
    }
}
