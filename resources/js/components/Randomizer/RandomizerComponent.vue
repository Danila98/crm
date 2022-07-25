<template>
    <div class="container " >

        <div class="card">
            <div>
                <label class="typo__label">Simple select / dropdown</label>
                <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                </multiselect>
            </div>
            <div class="tags">
                <div class="tag">
                    <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck">
                    <label class="form-check-label" for="disabledFieldsetCheck">
                        Can't check this
                    </label>
                </div>
                <div class="tag">
                    <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck">
                    <label class="form-check-label" for="disabledFieldsetCheck">
                        Can't check this
                    </label>
                </div>
            </div>
                <div class="view"  v-if="image">
                    <h1 class="card-header"> </h1>
                    <div class="card-body">
                        <img class="card_img"
                             :src="'storage/'+image.image"
                             alt="card">
                    </div>
                    <div class="badge" v-if="image.tags" v-for="tag in image.tags">
                        <span class="badge-light">{{ tag.name }}</span>
                    </div>
                </div>
                    <div class="buttons">
                <input type="button" id="0" v-on:click="getColor" class="btn btn-danger" value="Выбрать цвет">
                <input type="button" id="1" v-on:click="getColor" class="btn btn-success" value="Выбрать дизайн">
            </div>
        </div>

    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
    components: {
        Multiselect
    },
    data() {
        return {
            image: null,
            value: [],
            options: []
        };
    },
    mounted() {
        this.getTags();
    },
    methods: {
        getColor: function (event) {
            console.log(this.value);
            axios
                .get(`api/random`, { params: {
                        type: event.target.id,
                        tags: this.value.map((tag) => tag.id)
                    }
                })
                .then(response => (this.image = response.data));
        },
        getTags: function ()
        {
            axios
                .get(`api/tags`)
                .then(response => (this.options = response.data));
        }
    },

}
</script>
