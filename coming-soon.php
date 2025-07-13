<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include './layout/head.php' ?>

<body>

    <!-- preloader start -->
    <?php include './layout/preloader.php' ?>
    <!-- preloader end -->

    <!-- scroll to top button start -->
    <button class="scroll-to-top show" id="scrollToTop">
        <i class="ti ti-arrow-up"></i>
    </button>
    <!-- scroll to top button end -->

    <!-- header start -->
    <?php include './layout/header.php' ?>
    <!-- header end -->

    <!-- sidebar start -->
    <?php include './layout/sidebar.php' ?>
    <!-- sidebar end -->

    <!-- app layout start -->
    <div class="app-layout">

        <!-- main start -->
        <main>

            <!-- breadcrumb start -->
            <section class="pt-30p">
                <div class="section-pt">
                    <div
                        class="relative bg-[url('../images/photos/breadcrumbImg.png')] bg-cover bg-no-repeat rounded-24 overflow-hidden">
                        <div class="container">
                            <div class="grid grid-cols-12 gap-30p relative xl:py-[130px] md:py-30 sm:py-25 py-20 z-[2]">
                                <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                                    <h2 class="heading-2 text-w-neutral-1 mb-3">
                                        Coming Soon
                                    </h2>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0)" class="breadcrumb-link">
                                                Be with us - Something thriller coming soon...
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="overlay-11"></div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb end -->

            <section class="section-py">
                <div class="container">
                    <div class="flex-col-c text-center">
                        <h1 class="lg:text-[160px] md:text-[140px] sm:text-[120px] text-7xl font-borda text-w-neutral-1 mb-3">
                            Coming Soon
                        </h1>
                        <h1 class="heading-1 text-w-neutral-1 mb-24p">
                            We are cooking something great!
                        </h1>
                        <p class="text-l-medium text-w-neutral-4 mb-40p">
                            Wait a bit for a blockbuster gaming experience to come out. We are working hard to bring you something great.
                        </p>
                        <a href="index.php" class="btn btn-xl py-3 btn-primary rounded-12">
                            BACK TO HOME
                        </a>
                    </div>
                </div>
            </section>

        </main>
        <!-- main end -->

        <!-- footer start -->
        <?php include './layout/footer.php' ?>
        <!-- footer end -->
    </div>
    <!-- app layout end -->


</body>

</html>