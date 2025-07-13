<!-- header start -->
    <header id="header" class="absolute w-full z-[999]">
        <div class="mx-auto relative">
            <div id="header-nav" class="w-full px-24p bg-b-neutral-3 relative">
                <div class="flex items-center justify-between gap-x-2 mx-auto py-20p">
                    <nav class="relative xl:grid xl:grid-cols-12 flex justify-between items-center gap-24p text-semibold w-full">
                        <div class="3xl:col-span-6 xl:col-span-5 flex items-center 3xl:gap-x-10 gap-x-5">
                            <a href="index.html" class="shrink-0">
                                <img class="xl:w-[170px] sm:w-36 w-30 h-auto shrink-0" src="./assets/images/icons/logo.png" alt="brand" />
                            </a>
                            <form
                                class="hidden lg:flex items-center sm:gap-3 gap-2 min-w-[300px] max-w-[670px] w-full px-20p py-16p bg-b-neutral-4 rounded-full">
                                <span class="flex-c icon-20 text-white">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input autocomplete="off" class="bg-transparent w-full" type="text" name="search" id="search"
                                    placeholder="Search..." />
                            </form>
                        </div>
                        <div class="3xl:col-span-6 xl:col-span-7 flex items-center xl:justify-between justify-end w-full">
                            <a href="#"
                                class="hidden xl:inline-flex items-center gap-3 pl-1 py-1 pr-6  rounded-full bg-[rgba(242,150,32,0.10)] text-w-neutral-1 text-base">
                                <span class="size-48p flex-c text-b-neutral-4 bg-primary rounded-full icon-32">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-speakerphone">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 8a3 3 0 0 1 0 6" />
                                        <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                                        <path
                                            d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
                                    </svg>
                                </span>
                                News For You
                            </a>
                            <div class="flex items-center lg:gap-x-32p gap-x-2">
                                <!-- <div class="hidden lg:flex items-center gap-1 shrink-0">
                                    <a href="./shopping-cart.html" class="btn-c btn-c-lg btn-c-dark-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17h-11v-14h-2" />
                                            <path d="M6 5l14 1l-1 7h-13" />
                                        </svg>
                                    </a>
                                    <div class="relative hidden lg:block">
                                        <a href="chat.html" class="btn-c btn-c-lg btn-c-dark-outline">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div x-data="dropdown" class="dropdown relative shrink-0 lg:block hidden">
                                    <button @click="toggle()" class="dropdown-toggle gap-24p">
                                        <span class="flex items-center gap-3">
                                            <img class="size-48p rounded-full shrink-0" src="./assets/images/users/user1.png" alt="profile" />
                                            <span class="">
                                                <span class="text-m-medium text-w-neutral-1 mb-1">
                                                    David Malan
                                                </span>
                                                <span class="text-sm text-w-neutral-4 block">
                                                    270 Followars
                                                </span>
                                            </span>
                                        </span>
                                        <span :class="isOpen ? '-rotate-180' : ''"
                                            class="btn-c btn-c-lg text-w-neutral-4 icon-32 transition-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M6 9l6 6l6 -6" />
                                            </svg>
                                        </span>
                                    </button>

                                    <div x-show="isOpen" x-transition @click.away="close()" class="dropdown-content">
                                        <a href="./profile.html" class="dropdown-item">Profile</a>
                                        <a href="./user-settings.html" class="dropdown-item">Settings</a>
                                        <button type="button" @click="close()" class="dropdown-item">Logout</button>
                                        <a href="./contact-us.html" class="dropdown-item">Help</a>
                                    </div>
                                </div> -->

                                <button class="lg:hidden btn-c btn-c-lg btn-c-dark-outline nav-toggole shrink-0">
                                    <i class="ti ti-menu-2"></i>
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <nav class="w-full flex justify-between items-center">
                <div
                    class="small-nav fixed top-0 left-0 h-screen w-full shadow-lg z-[999] transform transition-transform ease-in-out invisible md:translate-y-full max-md:-translate-x-full duration-500">
                    <div class="absolute z-[5] inset-0 bg-b-neutral-3 flex-col-c min-h-screen max-md:max-w-[400px]">
                        <div class="container max-md:p-0 md:overflow-y-hidden overflow-y-scroll scrollbar-sm lg:max-h-screen">
                            <div class="p-40p">
                                <div class="flex justify-between items-center mb-10">
                                    <a href="index.php">
                                        <img class="w-[142px]" src="./assets/images/icons/logo.png" alt="GameCo" />
                                    </a>
                                    <button class="nav-close btn-c btn-c-md btn-c-primary">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-12 gap-x-24p gap-y-10 sm:p-y-48p">
                                    <div class="xl:col-span-8 md:col-span-7 col-span-12">
                                        <div
                                            class="overflow-y-scroll overflow-x-hidden scrollbar scrollbar-sm xl:max-h-[532px] md:max-h-[400px] md:pr-4">
                                            <ul class="flex flex-col justify-center items-start gap-20p text-w-neutral-1">
                                                <li class="mobail-menu">
                                                    <a href="index.php">Home</a>
                                                </li>
                                                <li class="mobail-menu">
                                                    <a href="games.php">Games</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="xl:col-span-4 md:col-span-5 col-span-12">
                                        <div class="flex flex-col items-baseline justify-between h-full">
                                            <form
                                                class="w-full flex items-center justify-between px-16p py-2 pr-1 border border-w-neutral-4/60 rounded-full">
                                                <input class="placeholder:text-w-neutral-4 bg-transparent w-full" type="text" name="search-media"
                                                    placeholder="Search Media" id="search-media" />
                                                <button type="submit" class="btn-c btn-c-md text-w-neutral-4">
                                                    <i class="ti ti-search"></i>
                                                </button>
                                            </form>
                                            <div class="mt-40p">
                                                <img class="mb-16p" src="./assets/images/icons/logo.png" alt="logo" />
                                                <p class="text-base text-w-neutral-3 mb-32p">
                                                    Become visionary behind a sprawling metropolis in Metropolis Tycoon Plan
                                                    empire
                                                    progress.
                                                </p>
                                                <div class="flex items-center flex-wrap gap-3">
                                                    <a href="#" class="btn-socal-primary">
                                                        <i class="ti ti-brand-facebook"></i>
                                                    </a>
                                                    <a href="#" class="btn-socal-primary">
                                                        <i class="ti ti-brand-twitch"></i>
                                                    </a>
                                                    <a href="#" class="btn-socal-primary">
                                                        <i class="ti ti-brand-instagram"></i>
                                                    </a>
                                                    <a href="#" class="btn-socal-primary">
                                                        <i class="ti ti-brand-discord"></i>
                                                    </a>
                                                    <a href="#" class="btn-socal-primary">
                                                        <i class="ti ti-brand-youtube"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-close min-h-[200vh] navbar-overly"></div>
                </div>
            </nav>
        </div>
    </header>
    <!-- header end -->