import { resolve } from "url";

export default class Node
{
  constructor(title, id)
  {
    this.parents = [];
    this.children = [];
    this.hpCache = [];
    
    this.title = title;
    this.id = id;
  }



  // canBeChild(id, queue)
  // {
  //   for (var i = 0; i < this.children.length; i++)
  //   {
  //     if (this.hasChild(id))
  //     {
  //       return(false);
  //     }   
  //   }
  //   for (var i = 0; i < this.parents.length; i++)
  //   {
  //     if (this.hasParent(id))
  //     {
  //       return(false);
  //     }
  //   }
    
  //   return(true);
    
  // }
  
  
  addChild(node)
  {
    node.parents.push(this);

    this.children.push(node);
  }
  
  removeChild(nodeId)
  {

    var index = this.children.findIndex((e) => e.id == nodeId);
    this.children.splice(index, 1);
  }
  
  addParent(node)
  {

    this.parents.push(node);
  }
  
  removeParent(nodeId)
  {
    var index = this.parents.findIndex((e) => e.id == nodeId);
    this.parents.splice(index, 1);
  }
}