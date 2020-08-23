<template>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{ 'mkeep.login' | trans }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="email">{{ 'mkeep.email' | trans }}</label>
                        <input name="email" type="email" v-model="email" class="form-control" :class="{'is-invalid': errors && errors.email}">
                        <span class="invalid-feedback" v-if="errors && errors.email">
                          <strong>{{ errors.email }}</strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="password">{{ 'mkeep.password' | trans }}</label>
                        <input name="password" type="password" v-model="password" class="form-control" :class="{'is-invalid': errors && errors.password}">
                        <span class="invalid-feedback" v-if="errors && errors.password">
                          <strong>{{ errors.password }}</strong>
                        </span>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="hidden" v-model="remember">
                            <input id="login-form-remember" type="checkbox" value="1" class="form-check-input" :checked="remember" @change="changeRemember()">
                            {{ 'mkeep.remember' | trans }}
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-group">
                        <a href="javascript: void(0);" class="btn btn-primary" @click="login">
                            <i class="material-icons">input</i> {{ 'mkeep.login' | trans }}
                        </a>&nbsp;<a href="/account/register" class="btn btn-success">
                            <i class="material-icons">person</i> {{ 'mkeep.register' | trans }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                email: '',
                password: '',
                remember: 0,
                errors: false
            };
        },
        methods: {
            /**
             *  switch remember
             */
            changeRemember: function() {
                this.remember = ($('#login-form-remember').prop('checked')?1:0);
            },
            /**
             * Save opeartion
             */
            login: function() {
                let self = this;
                let url = '/account/login';
                axios
                    .post(url, {'email': self.email,'password': self.password,'remember': self.remember})
                    .then((response) => {
                        if (response.data['errors']) {
                            this.errors = response.data['errors'];
                        } else {
                            document.location = '/';
                        }
                    })
            }
        }
    }
</script>