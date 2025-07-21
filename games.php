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
                    Games
                  </h2>
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="index.php" class="breadcrumb-link">
                        Home
                      </a>
                    </li>
                    <li class="breadcrumb-item">
                      <span class="breadcrumb-icon">
                        <i class="ti ti-chevrons-right"></i>
                      </span>
                    </li>
                    <li class="breadcrumb-item">
                      <span class="breadcrumb-current">Games</span>
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

      <!-- games section start -->
      <section class="section-pb pt-60p overflow-visible">
        <div class="container">
          <div class="grid grid-cols-12 gap-x-30p gap-y-10">
            <div class="xxl:col-span-9 xl:col-span-8 col-span-12 xl:order-1 order-2">
              <div id="gameContainer" class="grid xxl:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-30p">
              </div>

              <div
                class="pagination pagination-primary lg:pagination-center pagination-center pagination-circle pagination-xl w-full mt-48p">
                <a href="#" class="pagination-item pagination-prev">
                  <i class="ti ti-chevron-left"></i>
                </a>
                <div class="pagination-list">
                </div>
                <a href="#" class="pagination-item pagination-next">
                  <i class="ti ti-chevron-right"></i>
                </a>
              </div>

            </div>
            <div class="xxl:col-span-3 xl:col-span-4 col-span-12 order-1 xl:order-2 relative">
              <div class="xl:sticky xl:top-30">
                <div class="grid grid-cols-1 gap-30p *:bg-b-neutral-3 *:rounded-12 *:p-30p">
                  <div data-aos="fade-up">
                    <form class="flex items-center sm:gap-3 gap-2 text-w-neutral-1">
                      <span class="flex-c icon-24">
                        <i class="ti ti-search"></i>
                      </span>
                      <input autocomplete="off"
                        class="bg-transparent placeholder:text-w-neutral-1 w-full" type="text"
                        name="search" id="search" placeholder="Search..." />
                    </form>
                  </div>
                  <div data-aos="fade-up">
                    <h4 class="heading-4 text-w-neutral-1 mb-16p">Categories</h4>
                    <ul>
                      <li>
                        <div class="checkbox-container shrink-0">
                          <input type="checkbox" value="mind-game" id="platform-1"
                            class="border-corners-checkbox" checked>
                          <label for="platform-1" class="border-corners-checkbox-label gap-2">
                            <i class="ti icon-24 text-primary"></i>
                            Mind Games
                          </label>
                        </div>
                      </li>
                      <li>
                        <div class="checkbox-container shrink-0">
                          <input type="checkbox" value="puzzle-game" id="platform-2"
                            class="border-corners-checkbox" checked>
                          <label for="platform-2" class="border-corners-checkbox-label gap-2">
                            <i class="ti icon-24 text-primary"></i>
                            Puzzle Games
                          </label>
                        </div>
                      </li>
                      <li>
                        <div class="checkbox-container shrink-0">
                          <input type="checkbox" value="fun-game" id="platform-3"
                            class="border-corners-checkbox" checked>
                          <label for="platform-3" class="border-corners-checkbox-label gap-2">
                            <i class="ti icon-24 text-primary"></i>
                            Fun Games
                          </label>
                        </div>
                      </li>
                      <li>
                        <div class="checkbox-container shrink-0">
                          <input type="checkbox" value="luck-game" id="platform-4"
                            class="border-corners-checkbox" checked>
                          <label for="platform-4" class="border-corners-checkbox-label gap-2">
                            <i class="ti icon-24 text-primary"></i>
                            Luck Games
                          </label>
                        </div>
                      </li>
                      <li>
                        <div class="checkbox-container shrink-0">
                          <input type="checkbox" value="tools" id="platform-5"
                            class="border-corners-checkbox" checked>
                          <label for="platform-4" class="border-corners-checkbox-label gap-2">
                            <i class="ti icon-24 text-primary"></i>
                            Tools
                          </label>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- games section end -->

    </main>
    <!-- main end -->

    <script>
      const games = [{
          title: "Super Snake",
          image: "assets/images/game-pics/snake.jpg",
          url: "games/snake-game.php",
          category: "fun-game"
        },
        {
          title: "Arkanoid Ball",
          image: "assets/images/game-pics/ping-ball.jpg",
          url: "games/ping-ball.php",
          category: "fun-game"
        },
        {
          title: "Build The Block",
          image: "assets/images/game-pics/block-puzzle.jpg",
          url: "games/block-align-game.php",
          category: "puzzle-game"
        },
        {
          title: "Slide The Block",
          image: "assets/images/game-pics/block-slide.png",
          url: "games/block-slide-puzzle.php",
          category: "puzzle-game"
        },
        {
          title: "Rock Paper Scissors",
          image: "assets/images/game-pics/rock-paper-scissors.png",
          url: "games/rock-paper-scissors.php",
          category: "luck-game"
        },
        {
          title: "Flappy Ball",
          image: "assets/images/game-pics/flappy.png",
          url: "games/flappy-bird.php",
          category: "fun-game"
        },
        {
          title: "Tic Tac Toe",
          image: "assets/images/game-pics/tictac.png",
          url: "games/tic-tac.php",
          category: "fun-game"
        },
        {
          title: "Jigsaw",
          image: "assets/images/game-pics/jigsaw.jpg",
          url: "games/jigsaw-puzzle.php",
          category: "puzzle-game"
        },
        {
          title: "2048",
          image: "assets/images/game-pics/2048-Game.jpg",
          url: "games/2048-game.php",
          category: "mind-game"
        },
        {
          title: "Memory Match",
          image: "assets/images/game-pics/memory-match.jpg",
          url: "games/memory-match.php",
          category: "mind-game"
        },
        {
          title: "Sudoku",
          image: "assets/images/game-pics/sudoku-game.png",
          url: "games/sudoku-game.php",
          category: "mind-game"
        },
        {
          title: "Slot Spin",
          image: "assets/images/game-pics/slot-spin.jpg",
          url: "games/slot-spin.php",
          category: "luck-game"
        },
        {
          title: "Dino",
          image: "assets/images/game-pics/dino.png",
          url: "games/dino.php",
          category: "fun-game"
        },
        {
          title: "Hangman Word Quest",
          image: "assets/images/game-pics/word-quest.png",
          url: "games/hangman-word-quest.php",
          category: "mind-game"
        },
        {
          title: "Roll The Dice",
          image: "assets/images/game-pics/roll-the-dice.png",
          url: "games/role-dice.php",
          category: "luck-game"
        },
        {
          title: "Toss The Coin",
          image: "assets/images/game-pics/coin-toss.png",
          url: "games/coin-toss.php",
          category: "luck-game"
        },
        {
          title: "Simon Says",
          image: "assets/images/game-pics/simon-says.png",
          url: "games/simon-says.php",
          category: "mind-game"
        },
        {
          title: "Speed Typing",
          image: "assets/images/game-pics/typing-speed.png",
          url: "games/typing-speed.php",
          category: "tools"
        },
        {
          title: "Internet Speed Checker",
          image: "assets/images/game-pics/speed-tester.jpg",
          url: "games/speed-tester.php",
          category: "tools"
        },
      ];

      const gamesPerPage = 8;
      let currentPage = 1;

      function renderGames(page = 1) {
        const start = (page - 1) * gamesPerPage;
        const end = start + gamesPerPage;
        const paginatedGames = games.slice(start, end);

        const gameContainer = document.getElementById('gameContainer');
        gameContainer.innerHTML = ''; // clear previous

        paginatedGames.forEach(game => {
          gameContainer.innerHTML += `
        <div class="bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12" data-aos="zoom-in">
          <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
            <div class="glitch-thumb">
              <img class="w-full md:h-[228px] h-[200px] object-cover" src="${game.image}" alt="${game.title}" />
            </div>
            <div class="glitch-thumb">
              <img class="w-full md:h-[228px] h-[200px] object-cover" src="${game.image}" alt="${game.title}" />
            </div>
          </div>
          <div>
            <a href="${game.url}" class="heading-4 text-w-neutral-1 link-1 line-clamp-1 text-split-left">
              ${game.title}
            </a>
            <p class="text-l-regular text-w-neutral-2">
              ${game.category.replace('-', ' ')}
            </p>
          </div>
        </div>
      `;
        });

        renderPagination();
      }

      function renderPagination() {
        const totalPages = Math.ceil(games.length / gamesPerPage);
        const paginationList = document.querySelector('.pagination-list');
        paginationList.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
          paginationList.innerHTML += `
        <a href="#" class="pagination-item pagination-circle ${i === currentPage ? 'active' : ''}" data-page="${i}">
          <span class="pagination-link">${i}</span>
        </a>
      `;
        }

        // Handle next/prev states
        document.querySelector('.pagination-prev').style.visibility = currentPage === 1 ? 'hidden' : 'visible';
        document.querySelector('.pagination-next').style.visibility = currentPage === totalPages ? 'hidden' : 'visible';
      }

      // Pagination click handler
      document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination-item')) {
          e.preventDefault();

          const page = e.target.closest('.pagination-item').dataset.page;
          if (page) {
            currentPage = parseInt(page);
            renderGames(currentPage);
          }
        }

        if (e.target.closest('.pagination-prev')) {
          if (currentPage > 1) {
            currentPage--;
            renderGames(currentPage);
          }
        }

        if (e.target.closest('.pagination-next')) {
          const totalPages = Math.ceil(games.length / gamesPerPage);
          if (currentPage < totalPages) {
            currentPage++;
            renderGames(currentPage);
          }
        }
      });

      // Initial render
      renderGames(currentPage);
    </script>

    <!-- footer start -->
    <?php include './layout/footer.php' ?>
    <!-- footer end -->
  </div>
  <!-- app layout end -->


</body>

</html>