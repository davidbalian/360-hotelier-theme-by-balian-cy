<?php
/**
 * Template Name: Style Guide
 *
 * A comprehensive style guide showcasing all design elements and components.
 *
 * @package 360_Hotelier
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="site-container">
        <div class="style-guide">

            <header class="style-guide__header">
                <h1>Style Guide</h1>
                <p>A reference of all design elements, components, and patterns used throughout the 360&deg; Hotelier website.</p>
            </header>

            <!-- ============================================================
                 Colors
                 ============================================================ -->
            <section class="style-guide__section" id="sg-colors">
                <h2>Brand Colours</h2>
                <div class="sg-color-grid">
                    <div class="sg-color-swatch">
                        <div class="sg-color-swatch__preview" style="background-color: var(--color-purple);"></div>
                        <span class="sg-color-swatch__name">Purple</span>
                        <code>#5a2a82</code>
                    </div>
                    <div class="sg-color-swatch">
                        <div class="sg-color-swatch__preview" style="background-color: var(--color-orange);"></div>
                        <span class="sg-color-swatch__name">Orange</span>
                        <code>#f28c28</code>
                    </div>
                    <div class="sg-color-swatch">
                        <div class="sg-color-swatch__preview" style="background-color: var(--color-charcoal);"></div>
                        <span class="sg-color-swatch__name">Charcoal</span>
                        <code>#2b2b2b</code>
                    </div>
                    <div class="sg-color-swatch">
                        <div class="sg-color-swatch__preview" style="background-color: var(--color-sand);"></div>
                        <span class="sg-color-swatch__name">Sand</span>
                        <code>#f2e6d9</code>
                    </div>
                    <div class="sg-color-swatch">
                        <div class="sg-color-swatch__preview" style="background-color: var(--color-white);"></div>
                        <span class="sg-color-swatch__name">White</span>
                        <code>#fafafa</code>
                    </div>
                    <div class="sg-color-swatch">
                        <div class="sg-color-swatch__preview" style="background-color: var(--color-blue);"></div>
                        <span class="sg-color-swatch__name">Blue</span>
                        <code>#2c6e91</code>
                    </div>
                </div>
            </section>

            <!-- ============================================================
                 Typography
                 ============================================================ -->
            <section class="style-guide__section" id="sg-typography">
                <h2>Typography</h2>

                <div class="sg-subsection">
                    <h3>Font Family</h3>
                    <p class="sg-font-sample">Satoshi &mdash; the primary typeface used across the site, loaded locally in weights 300&ndash;900.</p>
                </div>

                <div class="sg-subsection">
                    <h3>Headings</h3>
                    <div class="sg-type-specimen">
                        <h1>Heading 1 &mdash; The quick brown fox</h1>
                        <h2>Heading 2 &mdash; The quick brown fox</h2>
                        <h3>Heading 3 &mdash; The quick brown fox</h3>
                        <h4>Heading 4 &mdash; The quick brown fox</h4>
                        <h5>Heading 5 &mdash; The quick brown fox</h5>
                        <h6>Heading 6 &mdash; The quick brown fox</h6>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Body Text</h3>
                    <p>This is a standard paragraph. The base font size is 1rem (16px) with a line-height of 1.6 for comfortable reading. Body text uses Satoshi in regular weight with the charcoal colour for optimal contrast and legibility.</p>
                    <p><strong>Bold text</strong> uses font-weight 700. <em>Italic text</em> uses the Satoshi Italic variant. <a href="#">Links are styled in blue</a> with a smooth colour transition on hover.</p>
                </div>

                <div class="sg-subsection">
                    <h3>Small &amp; Meta Text</h3>
                    <p><small>Small text used for captions, disclaimers, and fine print (0.875rem).</small></p>
                    <p class="entry-meta">Meta text style &mdash; used for dates, categories, and secondary info (0.8125rem).</p>
                </div>
            </section>

            <!-- ============================================================
                 Buttons
                 ============================================================ -->
            <section class="style-guide__section" id="sg-buttons">
                <h2>Buttons</h2>

                <div class="sg-subsection">
                    <h3>Primary Button</h3>
                    <p>Used for main calls-to-action. Orange background with white text.</p>
                    <div class="sg-button-row">
                        <a href="#" class="front-cta-button">Primary Button</a>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Secondary Button</h3>
                    <p>Used for alternative actions. Transparent with an orange border.</p>
                    <div class="sg-button-row">
                        <a href="#" class="front-cta-button front-cta-button--secondary">Secondary Button</a>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Button Pair</h3>
                    <p>Primary and secondary buttons used together.</p>
                    <div class="sg-button-row">
                        <a href="#" class="front-cta-button">Get Started</a>
                        <a href="#" class="front-cta-button front-cta-button--secondary">Learn More</a>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Text Link / Read More</h3>
                    <p>Used for inline navigation and "read more" patterns.</p>
                    <div class="sg-button-row">
                        <a href="#" class="read-more">Read more &rarr;</a>
                    </div>
                </div>
            </section>

            <!-- ============================================================
                 Lists
                 ============================================================ -->
            <section class="style-guide__section" id="sg-lists">
                <h2>Lists</h2>

                <div class="sg-columns">
                    <div class="sg-subsection">
                        <h3>Unordered List</h3>
                        <ul>
                            <li>Revenue management consulting</li>
                            <li>Online sales &amp; distribution</li>
                            <li>Digital marketing strategy</li>
                            <li>Tour operator contracting</li>
                        </ul>
                    </div>

                    <div class="sg-subsection">
                        <h3>Ordered List</h3>
                        <ol>
                            <li>Initial discovery &amp; audit</li>
                            <li>Strategy development</li>
                            <li>Implementation &amp; training</li>
                            <li>Ongoing optimisation</li>
                        </ol>
                    </div>
                </div>
            </section>

            <!-- ============================================================
                 Form Elements
                 ============================================================ -->
            <section class="style-guide__section" id="sg-forms">
                <h2>Form Elements</h2>

                <div class="sg-subsection">
                    <form class="sg-form" onsubmit="return false;">
                        <div class="sg-form__group">
                            <label for="sg-input">Text Input</label>
                            <input type="text" id="sg-input" placeholder="Enter your name">
                        </div>
                        <div class="sg-form__group">
                            <label for="sg-email">Email Input</label>
                            <input type="email" id="sg-email" placeholder="you@example.com">
                        </div>
                        <div class="sg-form__group">
                            <label for="sg-select">Select</label>
                            <select id="sg-select">
                                <option value="">Choose a service&hellip;</option>
                                <option>Revenue Management</option>
                                <option>Digital Marketing</option>
                                <option>Online Sales &amp; Distribution</option>
                                <option>Tour Operator Contracting</option>
                            </select>
                        </div>
                        <div class="sg-form__group">
                            <label for="sg-textarea">Textarea</label>
                            <textarea id="sg-textarea" rows="4" placeholder="Your message&hellip;"></textarea>
                        </div>
                        <div class="sg-form__group">
                            <button type="submit" class="front-cta-button">Submit</button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- ============================================================
                 Cards
                 ============================================================ -->
            <section class="style-guide__section" id="sg-cards">
                <h2>Cards</h2>

                <div class="sg-subsection">
                    <h3>Service Card</h3>
                    <p>Used on the services page and front page services overview.</p>
                    <div class="sg-card-grid">
                        <div class="front-services-overview__card">
                            <h4 class="front-services-overview__card-title">Revenue Management</h4>
                            <p class="front-services-overview__card-text">Maximise your hotel&rsquo;s revenue through data-driven pricing strategies, demand forecasting, and distribution channel optimisation.</p>
                        </div>
                        <div class="front-services-overview__card">
                            <h4 class="front-services-overview__card-title">Digital Marketing</h4>
                            <p class="front-services-overview__card-text">Boost your online presence with targeted campaigns, SEO, social media management, and content strategy tailored for hospitality.</p>
                        </div>
                        <div class="front-services-overview__card">
                            <h4 class="front-services-overview__card-title">Online Sales &amp; Distribution</h4>
                            <p class="front-services-overview__card-text">Optimise your distribution mix across OTAs, direct booking channels, and GDS to maximise occupancy and profitability.</p>
                        </div>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Feature Box</h3>
                    <p>Used in the &ldquo;Why Choose Us&rdquo; section to highlight key value propositions.</p>
                    <div class="sg-card-grid">
                        <div class="front-why-choose__box">
                            <h4 class="front-why-choose__box-title">Industry Expertise</h4>
                            <p class="front-why-choose__box-text">Decades of hands-on experience in hotel operations, revenue management, and hospitality consulting across Cyprus and Europe.</p>
                        </div>
                        <div class="front-why-choose__box">
                            <h4 class="front-why-choose__box-title">Tailored Solutions</h4>
                            <p class="front-why-choose__box-text">Every hotel is unique. We create bespoke strategies that align with your property&rsquo;s brand, market, and goals.</p>
                        </div>
                        <div class="front-why-choose__box">
                            <h4 class="front-why-choose__box-title">Measurable Results</h4>
                            <p class="front-why-choose__box-text">We focus on KPIs that matter &mdash; RevPAR, ADR, occupancy rates, and direct booking growth with transparent reporting.</p>
                        </div>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Post Card</h3>
                    <p>Used in blog listings and archive pages.</p>
                    <div class="sg-card-grid">
                        <article class="post-card">
                            <div class="post-thumbnail">
                                <div class="sg-image-placeholder" style="height: 200px;"></div>
                            </div>
                            <div class="post-content-wrap">
                                <h4 class="entry-title"><a href="#">5 Revenue Strategies for Boutique Hotels</a></h4>
                                <div class="entry-meta">March 10, 2026</div>
                                <div class="entry-summary">Discover actionable strategies to increase revenue at your boutique hotel without sacrificing the guest experience.</div>
                                <a href="#" class="read-more">Read more &rarr;</a>
                            </div>
                        </article>
                        <article class="post-card">
                            <div class="post-thumbnail">
                                <div class="sg-image-placeholder" style="height: 200px;"></div>
                            </div>
                            <div class="post-content-wrap">
                                <h4 class="entry-title"><a href="#">The Future of Hotel Distribution in Cyprus</a></h4>
                                <div class="entry-meta">February 22, 2026</div>
                                <div class="entry-summary">How the evolving landscape of OTAs and direct bookings is shaping hotel distribution strategies in the region.</div>
                                <a href="#" class="read-more">Read more &rarr;</a>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Step Card</h3>
                    <p>Used in the &ldquo;Our Approach&rdquo; section to outline process steps.</p>
                    <div class="sg-card-grid">
                        <div class="front-approach__step">
                            <h4 class="front-approach__step-title">1. Discovery</h4>
                            <p class="front-approach__step-text">We begin with a thorough audit of your property, market positioning, and current performance metrics.</p>
                        </div>
                        <div class="front-approach__step">
                            <h4 class="front-approach__step-title">2. Strategy</h4>
                            <p class="front-approach__step-text">Based on our findings, we develop a tailored roadmap with clear milestones and measurable objectives.</p>
                        </div>
                        <div class="front-approach__step">
                            <h4 class="front-approach__step-title">3. Implementation</h4>
                            <p class="front-approach__step-text">We work alongside your team to execute the plan, providing hands-on training and ongoing support.</p>
                        </div>
                        <div class="front-approach__step">
                            <h4 class="front-approach__step-title">4. Optimise</h4>
                            <p class="front-approach__step-text">Continuous monitoring and refinement ensures sustained growth and adaptation to market changes.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============================================================
                 Banners
                 ============================================================ -->
            <section class="style-guide__section" id="sg-banners">
                <h2>Banners</h2>

                <div class="sg-subsection">
                    <h3>Featured Banner (Purple)</h3>
                    <p>Full-width call-to-action banner with a purple background.</p>
                </div>
            </section>
        </div><!-- .style-guide -->
    </div><!-- .site-container -->

    <!-- Full-width banner demo (outside container) -->
    <section class="front-featured-banner">
        <div class="site-container">
            <h3 class="front-featured-banner__title">Ready to Transform Your Hotel&rsquo;s Performance?</h3>
            <p class="front-featured-banner__text">Partner with 360&deg; Hotelier and unlock your property&rsquo;s full revenue potential.</p>
            <a href="#" class="front-featured-banner__cta">Get in Touch</a>
        </div>
    </section>

    <div class="site-container">
        <div class="style-guide">

            <div class="sg-subsection">
                <h3>Contact Banner (Purple)</h3>
                <p>Variation used in the contact CTA section of the front page.</p>
            </div>
        </div>
    </div>

    <section class="front-contact">
        <div class="site-container">
            <h3 class="front-contact__title">Let&rsquo;s Work Together</h3>
            <p class="front-contact__text">Whether you need a full revenue strategy or a quick consultation, we&rsquo;re here to help.</p>
            <a href="#" class="front-contact__cta">Contact Us</a>
        </div>
    </section>

    <div class="site-container">
        <div class="style-guide">

            <!-- ============================================================
                 Section Titles
                 ============================================================ -->
            <section class="style-guide__section" id="sg-section-titles">
                <h2>Section Titles</h2>

                <div class="sg-subsection">
                    <h3>Centred Section Title + Subtitle</h3>
                    <p>Used at the top of front page sections.</p>
                    <div class="sg-demo-block">
                        <h3 class="front-section__title">Our Services</h3>
                        <p class="front-section__subtitle">Comprehensive hospitality consulting services designed to maximise your property&rsquo;s revenue and market position.</p>
                    </div>
                </div>
            </section>

            <!-- ============================================================
                 Layout & Spacing
                 ============================================================ -->
            <section class="style-guide__section" id="sg-layout">
                <h2>Layout &amp; Spacing</h2>

                <div class="sg-subsection">
                    <h3>Container</h3>
                    <p>The <code>.site-container</code> class constrains content to a max-width of <strong>1200px</strong> with <strong>20px</strong> horizontal padding.</p>
                </div>

                <div class="sg-subsection">
                    <h3>Spacing Scale</h3>
                    <div class="sg-spacing-samples">
                        <div class="sg-spacing-item">
                            <div class="sg-spacing-block" style="width: 16px; height: 16px;"></div>
                            <span>1rem (16px) &mdash; base unit</span>
                        </div>
                        <div class="sg-spacing-item">
                            <div class="sg-spacing-block" style="width: 24px; height: 24px;"></div>
                            <span>1.5rem (24px) &mdash; card padding, gaps</span>
                        </div>
                        <div class="sg-spacing-item">
                            <div class="sg-spacing-block" style="width: 32px; height: 32px;"></div>
                            <span>2rem (32px) &mdash; grid gaps, content padding</span>
                        </div>
                        <div class="sg-spacing-item">
                            <div class="sg-spacing-block" style="width: 48px; height: 48px;"></div>
                            <span>3rem (48px) &mdash; banner padding</span>
                        </div>
                        <div class="sg-spacing-item">
                            <div class="sg-spacing-block" style="width: 64px; height: 64px;"></div>
                            <span>4rem (64px) &mdash; section padding</span>
                        </div>
                    </div>
                </div>

                <div class="sg-subsection">
                    <h3>Responsive Breakpoint</h3>
                    <p><code>768px</code> &mdash; Mobile navigation appears, grid layouts stack to single column, and footer centres its content.</p>
                </div>
            </section>

            <!-- ============================================================
                 Borders & Shadows
                 ============================================================ -->
            <section class="style-guide__section" id="sg-borders">
                <h2>Borders &amp; Shadows</h2>

                <div class="sg-columns">
                    <div class="sg-subsection">
                        <h3>Default Border</h3>
                        <div class="sg-border-demo">
                            <code>1px solid var(--color-border)</code>
                            <br><code>border-radius: 6px</code>
                        </div>
                    </div>

                    <div class="sg-subsection">
                        <h3>Hover Shadow</h3>
                        <div class="sg-shadow-demo">
                            <code>box-shadow: 0 4px 20px rgba(0,0,0,0.08)</code>
                            <br>Hover over me
                        </div>
                    </div>
                </div>
            </section>

        </div><!-- .style-guide -->
    </div><!-- .site-container -->
</main>

<?php
get_footer();
