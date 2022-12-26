<!-- Start Portfolio Section -->
<?php $portfolios = get_portfolios(); ?>

<section id="portfolio" class="content">
    <h2 class="section-title">Portfolios</h2>
    <div class="portfolios">
        <?php
        foreach ($portfolios as $portfolio): ?>
        <div class="portfolio">
            <img src="<?php echo ($portfolio['image']) ?>" alt="">
            <h3><?php echo ($portfolio['title']) ?></h3>
            <div>
                <?php foreach ($portfolio['tags'] as $tag): ?>
                <span class="badge badge-warning"><?php echo ($tag); ?></span>
                <?php endforeach ?>
                <!-- <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                 <span class="badge badge-success">React JS</span> -->
            </div>
        </div>
        <?php endforeach ?>

        <!-- <div class="portfolio">
            <img src="images/portfolio-1.webp" alt="">
            <h3>Simple E-commerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-2.webp" alt="">
            <h3>Simple E-commerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-3.jpg" alt="">
            <h3>Simple E-commerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-1.webp" alt="">
            <h3>Simple E-commerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-2.webp" alt="">
            <h3>Simple E-commerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-3.jpg" alt="">
            <h3>Simple Ecommerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-2.webp" alt="">
            <h3>Simple Ecommerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div>
        <div class="portfolio">
            <img src="images/portfolio-3.jpg" alt="">
            <h3>Simple Ecommerce Application</h3>
            <div>
                <span class="badge badge-info">Ecommerce</span>
                <span class="badge badge-warning">Laravel</span>
                <span class="badge badge-success">React JS</span>
            </div>
        </div> -->
    </div>
</section>
<!-- End Portfolio Section -->