<template>
  <div>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <router-link
        class="sidebar-brand d-flex align-items-center justify-content-center"
        :to="{path:'/dashboard'}"
      >
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3" v-if="!setting">
          PROJECT TITLE HERE
        </div>
        <div class="sidebar-brand-text mx-3" v-if="setting">
          {{setting.title }}
        </div>
      </router-link>

      <!-- Divider -->
      <hr class="sidebar-divider my-0"/>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <!-- <a class="nav-link" href="index.html"> -->
        <router-link :to="{name:'dashboard'}" class="nav-link">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </router-link>
        <!-- </a> -->
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider" />

      <!-- Heading -->
      <div class="sidebar-heading">Interface</div>
      <li class="nav-item">
        
        <router-link :to="{ name: 'users'}" class="nav-link"><i class="fas fa-user-cog"></i> Users</router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapse-users"
          aria-expanded="true"
          aria-controls="collapse-users"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Users</span>
        </a> -->
        <!-- <div
          id="collapse-users"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'users'}" class="collapse-item">Users List</router-link>
          </div>
        </div> -->
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'customers'}" class="nav-link"><i class="fas fa-user-friends"></i> Party</router-link>

        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapse-customers"
          aria-expanded="true"
          aria-controls="collapse-customers"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Party</span>
        </a>
        <div
          id="collapse-customers"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'customers'}" class="collapse-item">Party List</router-link>
          </div>
        </div> -->
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'vendors'}" class="nav-link"><i class="fas fa-user-friends"></i> Vendors</router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapse-vendors"
          aria-expanded="true"
          aria-controls="collapse-vendors"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Vendors</span>
        </a>
        <div
          id="collapse-vendors"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'vendors'}" class="collapse-item">Vendor List</router-link>
          </div>
        </div> -->
      </li>
      <li class="nav-item">
        <router-link :to="{ path: '/products'}" class="nav-link"><i class="fas fa-box"></i> Particular List</router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapse-products"
          aria-expanded="true"
          aria-controls="collapse-products"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Particulars</span>
        </a>
        <div
          id="collapse-products"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ path: '/products'}" class="collapse-item">Particular List</router-link>
          </div>
        </div> -->
      </li>
      
      <li class="nav-item">
        <router-link :to="{ name: 'items'}" class="nav-link"><i class="fas fa-box"></i> Item </router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapse-Items"
          aria-expanded="true"
          aria-controls="collapse-Items"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Items</span>
        </a>
        <div
          id="collapse-Items"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'items'}" class="collapse-item">Item List</router-link>
          </div>
        </div> -->
      </li>
      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <router-link :to="{ name: 'invoices'}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Billing List</router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseTwo"
          aria-expanded="true"
          aria-controls="collapseTwo"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Billing</span>
        </a>
        <div
          id="collapseTwo"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'invoices'}" class="collapse-item">Billing List</router-link>
          </div>
        </div> -->
      </li>
      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <router-link :to="{ name: 'expenses'}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Purchase</router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseExpense"
          aria-expanded="true"
          aria-controls="collapseExpense"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Purchase</span>
        </a>
        <div
          id="collapseExpense"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'expenses'}" class="collapse-item">Purchase List</router-link>
          </div>
        </div> -->
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'settings'}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Settings</router-link>
        <!-- <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseSetting"
          aria-expanded="true"
          aria-controls="collapseSetting"
        >
          <i class="fas fa-fw fa-cog"></i>
          <span>Settings</span>
        </a>
        <div
          id="collapseSetting"
          class="collapse"
          aria-labelledby="headingTwo"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <router-link :to="{ name: 'settings'}" class="collapse-item">Setting List</router-link>
          </div>
        </div> -->
      </li>
      <li class="nav-item">
        <router-link :to="{ name: 'employees'}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Employee</router-link>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block" />
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
  name: "Sidebar",
  data(){
    return {}
  },
  computed:{
    ...mapGetters(['setting'])
  }
};
</script>

<style lang="scss" scoped>
</style>