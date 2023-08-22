export function sanitizeBlockAttributes(configAttributes){
  for(let configAttLabel in configAttributes){
    if(configAttributes[configAttLabel].choices){
      if(typeof configAttributes[configAttLabel].choices==='string' && configAttributes[configAttLabel].choices.indexOf('{{window')===0){

        var choices = /window--(.*?)}/g.exec(configAttributes[configAttLabel].choices);
        if(choices[1]){
          configAttributes[configAttLabel].choices = window[choices[1]];
        }
      }
    }
  }
  return configAttributes;
}