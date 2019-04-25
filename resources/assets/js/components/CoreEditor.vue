<template>
  <div id="editor">
    <h2>Выберите версию</h2>
    <ul class="select">
      <li v-for="(version, index) in coreVersions" :key="index"
         :class="versionSelected == index?'selected option':'option'" @click="versionSelected = index">{{version}}</li>
  <li @click="save" class="option selected">Сохранить данную версию</li>

    </ul>

    <div class="graph" v-if="ready">
      <div class="nodes" v-if="ready">

        <input type="text" v-model="nodeFilter" placeholder="Фильтр">
        <div ref="nedit" class="nodelist">
          <div v-for="(node, index) in nodes" :class="selected.id == node.id?'selected node':'node'" :key="index">
            <div class="f" @click="system.setCurrent(node.id)">
              {{node.title}}
            </div>
            <div>
              <div class="btn btn-danger" @click="removeNode(node.id)">&times;</div>
              <!-- <div class="btn btn-success" v-if="!haveParent(node.id)" @click="addParent(node)">Р</div> -->
              <div class="btn btn-primary" v-show="system.current.id != node.id" @click="addChild(node)">+</div>
            </div>
          </div>
        </div>

        <div class="fieldset">
          <input type="text" placeholder="Имя нового элемента" ref="nname">
          <div class="btn-add" @click="addNode">+</div>
        </div>
      </div>
      <div  class="node_edit" v-if="ready && selected">
        <input type="text" v-model="system.current.title" placeholder="Новое имя">
        <div class="split">
          <div class="wrap">
            <h4>Родители</h4>
            <div class="parents">
              <div class="node" v-for="(node, index) in parents" :key="index">
                <div class="f" @click="system.setCurrent(node.id)">
                  {{node.title}}
                </div>
                <div class="fieldset">
                  <div class="btn btn-danger float-right" @click="removeParent(node.id)">&times;</div>
                </div>

              </div>
            </div>
          </div>
          <div class="wrap">
            <h4>Дети</h4>
            <div class="children">

              <div class="node" v-for="(node, index) in children" :key="index">
                <div class="f" @click="system.setCurrent(node.id)">
                  {{node.title}}
                </div>
                <div class="fieldset">
                  <div class="btn btn-danger float-right" @click="removeChild(node.id)">&times;
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import _ from 'lodash';
  import NodeSystem from '../classes/NodeSystem';
import { constants } from 'crypto';

  export default {

    mounted() {
      axios.get('/insider/core/network').then(async (res) => {
        this.coreVersions = res.data;
        for (var i = 0; i < res.data.length; i++) {
          await axios.get(`/insider/core/network/1?version=${res.data[i]}`).then((data) => {
            var s = new NodeSystem();
            s.fromObject(data.data);
            this.systems.push(s);
          });
        }
        this.ready = true;

      }).catch((e) => {
        console.error(e)
      })

    },
    computed: {
      selected() {
        return this.system.current;
      },
      nodes() {
        var nodes = this.system.nodes;
        var reg = new RegExp(
          this.nodeFilter.replace(/[^sStTnNvVfFrR0]/g, (e) => `\\${e}`),
          'i'
        );      

        return this.system.nodes.filter((e) => e.title.match(reg));
      },
      children() {
        return this.system.current.children;
      },
      parents() {
        return this.system.current.parents;
      },
      system()
      {
        return this.systems[this.versionSelected];
      }
    },
    methods: {
      removeChild(id) {
        return this.system.current.removeChild(id);
      },
      removeParent(id) {
        return this.system.current.removeParent(id);
      },
      removeNode(id) {
        this.system.removeNode(id);
      },
      addParent(node) {
        return this.system.current.addParent(node);
      },
      addChild(node) {
        return this.system.current.addChild(node);
      },
      allocId()
      {
        var max = this.system.nodes[0];
        for (var i = 0; i < this.systems.length; i++)
        {
          max =  _.maxBy(this.systems[i].nodes, 'id');
        }
        console.log(max.id+1);
        return max.id+1;

      },
      // haveParent(id)
      // {
      //   return this.system.current.haveParent(id) || this.system.find(id).haveParent(this.system.current.id);
      // },
      // haveChild(id)
      // {
      //   return !this.system.find(id).canBeChild(this.system.current.id);
      // },
      addNode() {
        var title = this.$refs.nname.value;
        this.system.addNode(title, this.allocId());

        setTimeout(() => {this.$refs.nedit.scrollTop =  this.$refs.nedit.scrollHeight+123}, 100);
      },
      save()
      {
        console.log(this.system.toObject());
      }
    },
    data() {
      return {
        coreVersions: [],
        systems: [],
        versionSelected: 2,
        nodeFilter: "",
        lastNodeId: 0,
        ready: false,
        newTitle: ""
      }
    },
    name: 'core-editor'
  }
</script>


<style scoped>
  .graph {
    border-bottom: 1px solid #CCC;
    display: flex;
    max-height: 400px;

  }

  .nodes {
    border-right: 1px solid #ccc;
  }

  .split {
    display: flex;

  }

  .f {
    flex: 1;
    padding: 10px 20px;
  }

  .split>* {
    flex: 1;
  }

  .parents .node,
  .children .node {
    border: none !important;
  }

  .nodelist {
    overflow: auto;
    flex: 1;
  }

  .nodes {
    flex: 1;
    display: flex;
    flex-direction: column;

  }

  .parents {
    border-top: 2px solid #2c78c9;
  }

  .children {
    border-top: 2px solid green;
  }

  .node {
    align-items: stretch;
    display: flex;
    justify-content: space-between;
  }

  .node_edit {
    flex: 1;

    overflow: auto;
  }

  h4 {
    padding: 4px !important;
  }

  input[type=text] {
    padding: 10px 20px;
    box-sizing: border-box;
    width: 100%;
    border: none;
    border-bottom: 1px solid #ccc;
  }

  .node {
    cursor: pointer;
  }

  .node:hover {
    background: #eee;
  }

  .node.selected {
    background: #2c78c9;
    color: #fff;
  }

  .select {
    margin: 0 !important;
    padding-left: 30px !important;
    padding-bottom: 20px;
    flex-wrap: wrap;
    display: flex;
    border-bottom: 1px solid #ccc;
  }

  h2 {
    padding: 30px;
  }

  .option {
    margin-right: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    list-style: none;
    cursor: pointer;
    padding: 10px 20px;
    flex-direction: column;

    color: #2c78c9;
    border: 1px solid #2c78c9;
  }

  .option.selected {
    color: #fff;
    background: #2c78c9;
    border-color: #2c78c9 !important;
  }

  .fieldset {
    display: flex;

  }

  .fieldset input {

    border: none;
    border-top: 1px solid #ccc;
    flex: 1;
  }

  .btn-add {
    background: #2c78c9;
    color: #fff;
    font-size: 30px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 15px;
    text-align: center;

  }
</style>