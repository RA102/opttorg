<div class="row">
    <div class="col-md-12">
        <h2>Данные покупателя</h2>
        <form class="col-md-8 offset-2 shadow p-3 mb-5 bg-white rounded" action="/shop/order.html" method="post">

            <div class="form-row">
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="validationServer01">Имя, Фамилия</label>
                    <input type="text" class="form-control" id="validationServer01" name="name" placeholder="Имя, Фамилия" required>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <label for="validationServer02">Email</label>
                    <input type="email" class="form-control " id="validationServer02" name="email" placeholder="Email">
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
                            placeholder="+7 xxx xxx xx xx"
{*                            {literal}pattern="[0-9]{1} [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"{/literal}*}
                            required
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
                    <button class="btn float-right" style="background: #ff9600; color: #ffffff; border-radius: 10px; font-weight: 400; outline: none;" type="submit">Далее</button>
                </div>
            </div>
        </form>
    </div>
</div>
{*{literal}*}
{*<script type="text/javascript">*}
{*    $(function() {*}
{*        //2. Получить элемент, к которому необходимо добавить маску*}
{*        $("#phone").mask("8 (999) 999 99 99");*}
{*    });*}
{*</script>*}
{*{/literal}*}