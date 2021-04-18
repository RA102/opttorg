<div id="app">
    <v-app id="inspire">
        <v-app id="inspire">
            <v-main>
                <v-container
                        class="fill-height"
                        fluid
                >
                    <v-row justify="center">
                        <v-col
                                cols="12"
                                sm="10"
                                md="8"
                                lg="6"
                        >
                            <v-card ref="form">
                                <v-card-text>
                                    <v-text-field
                                            ref="name"
                                            v-model="name"
                                            :rules="[() => !!name || 'This field is required']"
                                            :error-messages="errorMessages"
                                            label="Имя, Фамилия"
                                            placeholder="Имя, Фамилия"
                                            solo
                                            required
                                    ></v-text-field>
                                    <v-text-field
                                            ref="address"
                                            v-model="address"
                                            :rules="[
                                            () => !!address || 'This field is required',
                                            () => !!address && address.length <= 25 || 'Address must be less than 25 characters',
                                            addressCheck
                                            ]"
                                            solo
                                            label="Адрес"
                                            placeholder="7-ое Авеню"
                                            counter="25"
                                            required
                                    ></v-text-field>

                                    <v-text-field
                                            ref="address"
                                            v-model="phone"
                                            :rules="[
                                            () => !!phone || 'This field is required',
                                            addressCheck
                                            ]"
                                            solo
                                            clearable
                                            label="Телефон"
                                            placeholder=""
                                            required
                                    ></v-text-field>

                                    <v-autocomplete
                                            ref="city"
                                            v-model="city"
                                            :rules="[() => !!city || 'This field is required']"
                                            solo
                                            clearable
                                            :items="cities"
                                            label="Город"
                                            placeholder="Выбрать..."
                                            required
                                    ></v-autocomplete>
                                </v-card-text>
                                <v-divider class="mt-12"></v-divider>
                                <v-card-actions>
                                    <v-btn
                                        text
                                        v-on:click="backUrl"
                                    >
                                        Назад
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-slide-x-reverse-transition>
                                        <v-tooltip
                                                v-if="formHasErrors"
                                                left
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn
                                                        icon
                                                        class="my-0"
                                                        v-bind="attrs"
                                                        @click="resetForm"
                                                        v-on="on"
                                                >
                                                    <v-icon>mdi-refresh</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Refresh form</span>
                                        </v-tooltip>
                                    </v-slide-x-reverse-transition>
                                    <v-btn
                                            dark
                                            color="#ff9600"
                                            @click="submit"
                                    >
                                        Дальше
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
    </v-app>
</div>

{literal}
<script>
    let customerForm = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            //countries: [], //['Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Anguilla', 'Antigua &amp; Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia &amp; Herzegovina', 'Botswana', 'Brazil', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Cape Verde', 'Cayman Islands', 'Chad', 'Chile', 'China', 'Colombia', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D Ivoire', 'Croatia', 'Cruise Ship', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Polynesia', 'French West Indies', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kuwait', 'Kyrgyz Republic', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Mauritania', 'Mauritius', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Pierre &amp; Miquelon', 'Samoa', 'San Marino', 'Satellite', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'South Africa', 'South Korea', 'Spain', 'Sri Lanka', 'St Kitts &amp; Nevis', 'St Lucia', 'St Vincent', 'St. Lucia', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', `Timor L'Este`, 'Togo', 'Tonga', 'Trinidad &amp; Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks &amp; Caicos', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Venezuela', 'Vietnam', 'Virgin Islands (US)', 'Yemen', 'Zambia', 'Zimbabwe'],
            errorMessages: '',
            name: null,
            address: null,
            phone: null,
            cities: [],
            city: null,
            formHasErrors: false,

        },

        computed: {
            form () {
                return {
                    name: this.name,
                    address: this.address,
                    city: this.city,
                    cities: this.cities
                }
            },
        },

        watch: {
            name () {
                this.errorMessages = ''
            },
        },

        methods: {

            initAppProc(){
               this.getListCities();
            },

            addressCheck () {
                this.errorMessages = this.address && !this.name ? `Hey! I'm required` : ''
                return true
            },
            resetForm () {
                this.errorMessages = []
                this.formHasErrors = false

                Object.keys(this.form).forEach(f => {
                    this.$refs[f].reset()
                })
            },
            submit () {
                this.formHasErrors = false

                Object.keys(this.form).forEach(f => {
                    if (!this.form[f]) this.formHasErrors = true

                    // this.$refs[f].validate(true)

                })

                axios.get('/shop/order.html', {
                    params: {
                        city: this.city,
                        name: this.name,
                        address: this.address,
                        phone: this.phone
                    }
                })
                .then( (response) => {
                    console.log(response);
                    window.location.href = '/shop/order.html'
                })
                .catch( error => console.log(error))

            },

            getListCities() {
                axios.get('/shop/list-cities')
                .then((response) => {
                    customerForm.cities = response.data.data;
                })
                .catch(error=> console.log(error))
            },

            backUrl(event) {
                window.location.href = '/shop/cart.html';
            }
        },
        mounted() {
            this.initAppProc()
            // axios
            // .get('https://api.coindesk.com/v1/bpi/currentprice.json')
            // .then(response => (this.info = response));
        }
    })
</script>
{/literal}