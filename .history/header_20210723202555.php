    <!-- ヘッダー -->
    <header id="l-header" class="u-bgColor">
        <div class="c-header">
            <a href="index.php" class="c-header__logo u-flex">
                <div class="c-header__img">
                    <img src="images/illust2.png" alt="">
                </div>
                <h3>ノウハン</h3>
            </a>
            <nav class="c-header__nav js-header-nav">
                <ul class="c-header__list u-flex js-header-list">
                    <?php if(!empty($_SESSION['login_date']) && time() <= $_SESSION['login_date'] + $_SESSION['login_limit']){ ?>
                    
                        <li class="c-header__item">
                            <a href="index.php" class="c-header__text">TOP</a>
                        </li>
                        <li class="c-header__item">
                            <a href="mypage.php" class="c-header__text">マイページ</a>
                        </li>
                        <li class="c-header__item">
                            <a href="logout.php" class="c-header__text">ログアウト</a>
                        </li>

                    <?php }else{ ?>

                    <li class="c-header__item">
                        <a href="index.php" class="c-header__text">TOP</a>
                    </li>
                    <li class="c-header__item">
                        <a href="login.php" class="c-header__text">ログイン</a>
                    </li>
                    <li class="c-header__item">
                        <a href="signup.php" class="c-header__text">ユーザー登録</a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header><!-- /ヘッダー -->