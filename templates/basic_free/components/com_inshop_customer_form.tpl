<div class="row">
    <div class="col-md-12">
        <div class="col-sm-12 offset-sm-0 col-md-12 offset-md-0 col-lg-12 offset-lg-0 col-xl-8 offset-xl-2 shadow p-3 mb-5 bg-white rounded">
            <h2 class="text-center">Данные покупателя</h2>
            <p class="text-center">Укажите ваш город чтобы узнать стоимость доставки</p>
            <p class="text-center">Укажите ваш телефон чтобы в случае заказа мы могли связаться с вами</p>
            <form class="col-12 was-validated" action="/shop/order.html" method="post">
                <div class="form-row">
                    <div class="col-sm-12 col-md-6 mb-3">
                        <label for="validationServer01">Имя, Фамилия</label>
                        <input
                                type="text"
                                class="form-control"
                                id="validationServer01"
                                name="name"
                                aria-describedby="nameHelp"
                                placeholder="Имя, Фамилия"
                                required
                        >
                        <small id="nameHelp" class="form-text text-muted">Обязательно для заполнения</small>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <label for="">Email</label>
                        <input
                                type="email"
                                class="form-control "
                                id=""
                                name="email"
                                aria-describedby="emailHelp"
                                placeholder="Email"
                        >
                        <small id="emailHelp" class="form-text text-muted">Не обязательно для заполнения</small>
                    </div>
                </div>
                <div class="form-row">
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="address">Адрес</label>
                    <input
                            type="text"
                            class="form-control "
                            id="address"
                            name="address"
                            placeholder="Адрес"
                            aria-describedby="inputGroupPrepend3"
                            required
                    >
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="phone">Телефон</label>
                    <input
                            type="tel"
                            class="form-control "
                            id="phone"
                            name="phone"
                            title="Введите телефон в формате +7 xxx xxx xx xx"
                            required
                            pattern="{literal}[^+[0-9]{1}[0-9]{3}][0-9]{3}[0-9]{2}{/literal}"
                    >
                </div>
            </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3 dropup" >
                        <label for="validationServer03">Город</label>
                        <select
                                id="city"
                                class="selectpicker form-control"
                                name="city"
                                data-live-search=true
                                data-dropup-auto="false"
                                data-live-search-normalize=false
                                data-width="100%"
                                data-size="10"
                                title="Выбор города..."
                                required
                        ></select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <a class="btn btn-default float-left" href="/shop/cart.html" title="чтобы вернуться голосом скажите назад">Назад</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn float-right" style="background: #ff9600; color: #ffffff; border-radius: 10px; font-weight: 400; outline: none;" type="submit" name="userInfo">Далее</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(function() {
            //2. Получить элемент, к которому необходимо добавить маску
            $("#phone").val("+7");
        });
    </script>
{/literal}