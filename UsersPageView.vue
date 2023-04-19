<template>
  <div class="users-container">
    <div class="users-container__header">
      <h1 class="users-container__header__title">Users</h1>
      <div class="users-container__header__actions">
        <UiButton class="users-container__action" @click="openCreateUserModal">
          Create user
        </UiButton>
      </div>
    </div>
    <div class="users-container__content">
      <div class="users-container-list">
        <div
            class="users-container-list__item"
            v-for="user in users"
            v-if="user.isVisible"
            :key="user.id"
        >
          <UsrAvatar :user="user"></UsrAvatar>
          <div class="users-container-list__user-info">
            <div class="users-container-list__user-name">
              {{ user.firstName + ' ' + (user.middleName ? user.middleName + ' ' : '') + user.lastName }}
            </div>
            <div class="users-container-list__user-email">
              {{ user.email }}
            </div>
          </div>
          <div class="users-container-list__actions" ref="actions">
            <div class="users-container-list__action">
              <base-button
                  v-if="currentUser.isAdmin && currentUser.hasEditPermission"
                  class="users-container-list__action-button"
                  v-on:click="openEditUserModal(user)"
              >
                Edit
              </base-button>
            </div>
            <div class="users-container-list__action">
              <base-button
                  v-if="currentUser.isAdmin && currentUser.hasDeletePermission"
                  class="users-container-list__action-button"
                  @click="openDeleteUserModal(user)"
              >
                Delete
              </base-button>
            </div>
          </div>
        </div>
      </div>
      <userFooter/>
    </div>
  </div>
</template>
<script>
import UserFooter from '@/components/UserFooter';
import UsrAvatar from '@/components/UsrAvatar';
import BaseButton from '@/components/BaseButton';

export default {
  name: 'UsersPageView',
  props: ['users'],
  components: {
    UserFooter,
    UsrAvatar,
    BaseButton,
  },
  data() {
    return {
      currentUser: this.$store.getters['auth/user'],
    };
  },
  methods: {
    openCreateUserModal() {
      this.$emit('openCreateUserModal');
    },
    openEditUserModal(user) {
      this.$emit('openEditUserModal', user);
    },
    openDeleteUserModal(user) {
      this.$emit('openDeleteUserModal', user);
    },
  },
};
</script>

<style lang="scss">
.users-container {
  display: flex;
  flex-direction: column;
  height: 100%;
  width: 100%;
  &__header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    height: 60px;
    border-bottom: 1px solid #e5e5e5;
    &__title {
      font-size: 24px;
      font-weight: 500;
      color: #000000;
    }
    &__actions {
      display: flex;
      flex-direction: row;
      align-items: center;
    }
  }
  &__content {
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: auto;
    padding: 20px;
  }

}
</style>
