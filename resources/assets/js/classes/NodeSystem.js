import Node from './Node';
import Connection from './Connection';

export default class NodeSystem
{
  constructor()
  {
    this.nodes = [];
    this.current = null;
  }

  setCurrent(id)
  {
    this.current = this.nodes.find((e) => e.id == id);
  }

  find(id)
  {
    return this.nodes.find((e) => e.id == id)
  }

  addNode(title, id)
  {
    this.nodes.push(new Node(title, id));
  }

  removeNode(id)
  {
    this.nodes.splice(find(id).id, 1);
  }

  toObject()
  {
    var obj = {
      nodes: [],
      edges: []
    };
    this.nodes.forEach((e) => {
      obj.nodes.push({
        title: e.title,
        id: e.id,
        nodeType: "exists",

      });
      e.children.forEach((i) => {
        obj.edges.push({
          source: e.id,
          target: i.id,
          type: "partOf"

        })
      });
    })
    return obj;
  }

  fromObject(obj)
  {
    console.log(obj.nodes.length);
    console.log(obj.edges.length);
    this.nodes = [];
    var parents = [];
    var children = [];

    obj.nodes.forEach((e) => {
      this.nodes.push(new Node(e.title, e.id));
    });

    obj.edges.forEach((e) => {
      var parent = this.nodes.find((i) => e.from_id == i.id);
      var child = this.nodes.find((i) => e.to_id == i.id);
      children.push(new Connection(parent, child));
      parents.push(new Connection(child, parent));


    });
    
    parents.forEach((e) => {
      e.source.addParent(e.target);
    })
    children.forEach((e) => {
      e.source.addChild(e.target);
    })


    this.current = this.nodes[0];

  }

}