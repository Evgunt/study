<section class="login_section">
    <h1 class="text_of_registration">Авторизация</h1>

    <?php
    if (!app()->auth::check()):
        ?>
        <form method="post" class="login_form">
            <label><input placeholder="Логин" type="text" name="login"></label>
            <label><input placeholder="Пароль" type="password" name="password"></label>
            <button>Войти</button>
        </form>
    <?php endif;?>
</section>