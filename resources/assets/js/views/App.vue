<template>
  <v-app id="inspire">
    <v-toolbar color="indigo" dark fixed app clipped-left>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <img class="cdb-toolbar-icon" src="img/cibolaicon.svg" alt="Cibola CMS">
      <v-toolbar-title>Cibola CRM</v-toolbar-title>
    </v-toolbar>
    <v-navigation-drawer
      fixed
      v-model="drawer"
      app
      clipped
      width="200"
    >
      <v-list dense class="cdb-app-drawer">
        <v-list-tile :to="{ name: 'home' }" :exact="true">
            <v-list-tile-action>
                <v-icon>dashboard</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Home</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'jobs'}">
          <v-list-tile-action>
            <v-icon>work</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Jobs</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'goldcredits' }">
          <v-list-tile-action>
            <v-icon>credit_card</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Gold Credits</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'customers' }">
          <v-list-tile-action>
            <v-icon>person</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Customers</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'employee' }">
          <v-list-tile-action>
            <v-icon>folder</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Employee</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'admin' }">
          <v-list-tile-action>
            <v-icon>list</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Admin</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-content>
      <v-container fluid grid-list-md>
          <alert></alert>                                
          <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      drawer: null
    }),
    props: {
      source: String
    }
  }
</script>