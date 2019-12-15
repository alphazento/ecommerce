<v-list dense nav>
  @if (Auth::user() && !Auth::user()->guest())
    <v-list-item>
      <v-list-item-avatar>
        <v-icon color="grey">mdi-account</v-icon>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title>
          <a href="/my-account">Account</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>Orders</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>Buy Again</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  @else
    <v-list-item>
      <v-list-item-avatar>
        <v-icon color="grey">mdi-account</v-icon>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title>
          <a href="/login" @click="slot_props.signin($event)">Account</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  @endif
  <v-divider></v-divider>
  <v-list-item>
    <v-list-item-content>
      <v-list-item-title><a href="/">Home</a></v-list-item-title>
    </v-list-item-content>
  </v-list-item>
  <v-list-item>
    <v-list-item-content>
      <v-list-item-title>Today's Deals</v-list-item-title>
    </v-list-item-content>
  </v-list-item>
  <v-list-item>
    <v-list-item-content>
      <v-list-item-title>Shop By Categories</v-list-item-title>
    </v-list-item-content>
  </v-list-item>
</v-list>