export default {
    auth: {
      login: `/auth/login`,
      logout: `/auth/logout`,
      register: `/auth/register`,
      state: `/auth/state`,
    },
    accountGroup: {
      index: `/app/account/groups`,
      detail: `/app/account/groups/{id}`,
    },
    account: {
      index: `/app/accounts`,
      detail: `/app/accounts/{id}`,
    },
    registry: `/app/registry`,
  }