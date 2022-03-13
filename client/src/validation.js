// import { required, minLength, maxLength, between, email, numeric } from 'vuelidate/lib/validators'
export default class {
  constructor(caller){
    this.caller = caller
  }
  
  hasError(field, fieldLabel){
    return this.errorText(field, fieldLabel) != ''
  }
  
  errorText(field, fieldLabel){
    //(accountErrors && accountErrors.name != null) || $v.account.name.$error
    //accountErrors.name ? accountErrors.name[0] : (!$v.account.name.required ? 'Field is required': ''
    const parts = field.split('.')
    if (parts.length > 0){
      const model = parts[0]
      const modelErrors = model+'Errors'
      if (!this.caller.$v.hasOwnProperty(model)) { this.caller.$v[model] = {} }
      if (!this.caller.hasOwnProperty(modelErrors)) { this.caller[modelErrors] = {} }
      let modelVuelidateErrorValue = this.caller.$v[model]
      let modelServerErrorValue = this.caller[modelErrors]
      for (let i = 1; i < parts.length; i++){
        if (!modelVuelidateErrorValue.hasOwnProperty(parts[i])) { modelVuelidateErrorValue[parts[i]] = {} }
        if (!modelServerErrorValue.hasOwnProperty(parts[i])) { modelServerErrorValue[parts[i]] = {} }
        modelVuelidateErrorValue = modelVuelidateErrorValue[parts[i]]
        modelServerErrorValue = modelServerErrorValue[parts[i]]
      }

      if (modelServerErrorValue && modelServerErrorValue.constructor != {}.constructor){
        return modelServerErrorValue.toString()
      }
      if (modelVuelidateErrorValue.$error){ /* $v.form.password.$params.minLength.min */
        if (modelVuelidateErrorValue.hasOwnProperty('required') && !modelVuelidateErrorValue.required) { return fieldLabel + ' is required' }
        if (modelVuelidateErrorValue.hasOwnProperty('email') && !modelVuelidateErrorValue.email) { return fieldLabel + ' must be a valid email address' }
        if (modelVuelidateErrorValue.hasOwnProperty('numeric') && !modelVuelidateErrorValue.numeric) { return fieldLabel + ' must be a number' }
        if (modelVuelidateErrorValue.hasOwnProperty('maxLength') && !modelVuelidateErrorValue.maxLength) { return fieldLabel + ' must contain at most '+ modelVuelidateErrorValue.$params.maxLength.max + ' characters' }

        return 'Unknown validation error'
      }
    }
    return ''
  }
  
}