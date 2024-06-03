# app.py
from flask import Flask, render_template, request, redirect, url_for, send_file
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
from PIL import Image
import numpy as np
import os
import pickle

app = Flask(__name__)


# Set up a folder to store uploaded and processed images
UPLOAD_FOLDER = 'static'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

main_Dir = os.getcwd()
print(main_Dir)
# Load the models 
ratinopathy_model =     load_model(r"Ratinopathy.h5")         # model
alzehmir_model =    load_model(r"Alzehmir.h5")            # model1
lung_model =        load_model(r"LungCancer.h5")          # model2


# classes for all model
ratinopathy_classes =   ["Dibatic","Diabitic Ratinopathy Detected" , "Moderate " , "Normal", "Several"]        # classes
alzehmir_class =    ["Mild ","Moderete" , "very mild" , "NO"]                   # classes1 
lung_class =        ["Adenocarcinoma","Large Cell Carninoma" ,"Normal" ,  "Squamous Carninoma"]    # classes2



# 0. Heart_Disease

#[male,age,education,currentSmoker,cigsPerDay,BPMeds,prevalentStroke,prevalentHyp,diabetes,totChol,sysBP,diaBP,BMI,heartRate,glucose]

@app.route('/heart')
def heart():
    return render_template('heart.html')


@app.route('/HeartFnc',methods=['POST','GET'])
def HeartFnc():

    # getting value from form
    male =  float(request.form.get('gender'))
    age =  float(request.form.get('age'))
    education =  float(request.form.get('education'))
    currentSmoker =  float(request.form.get('currentSmoker'))
    cigsPerDay =  float(request.form.get('cigsPerDay'))
    BPMeds =  float(request.form.get('BPMeds'))
    prevalentStroke =  float(request.form.get('prevalentStroke'))
    prevalentHyp =  float(request.form.get('prevalentHyp'))
    diabetes =  float(request.form.get('diabetes'))
    totChol =  float(request.form.get('totChol'))
    sysBP =  float(request.form.get('sysBP'))
    diaBP =  float(request.form.get('diaBP'))
    BMI =  float(request.form.get('BMI'))
    heartRate =  float(request.form.get('heartRate'))
    glucose =  float(request.form.get('glucose'))

    values = [male,age,education,currentSmoker,cigsPerDay,BPMeds,prevalentStroke,prevalentHyp,diabetes,totChol,sysBP,diaBP,BMI,heartRate,glucose]
    val = Heart_Disease(values)

    return render_template('heart.html',val = val)



def Heart_Disease(values):
    values = [values]
    # values = [[0,63,1,1,3,0,0,1,0,267,156.5,92.5,27.1,60,79]]
    model = pickle.load(open(r'Heart_Disease.pkl','rb'))
    values = np.asarray(values)
    print(values)
    print(type(values))
    pred =    model.predict(values)
    print(pred)
    if pred >= 0.5 :
        output = 'Heart Disease will stay more than 10 years'
    elif pred <= .51 :
        output = 'You Heart is Healthy'
    
    return output



# 1. Diabitic zone

@app.route('/diabetes')
def diabetes():
    return render_template('diabitic.html')


def Diabetes(values):
    # here it converting in 2-d array values itself in 1-d format
    values = [values]

    # opening the model 
    model =  pickle.load(open(r"Diabetes2.pkl",'rb'))
    values = np.asarray(values)                         # converting the value in array
    pred =   model.predict(values)
    #pred =   int(pred[0])

    if pred <= 0.5 :
        output = 'No Diabetes'
        text_color='green'

    elif pred >= .51 :
        output = 'Diabetes'
        text_color='red'
    
    return output



@app.route('/DiabetesFunc',methods=['POST','GET'])
def DiabetesFunc():

    # getting value from form
    gender =  float(request.form.get('gender'))
    age =  float(request.form.get('age'))
    hypertension = float(request.form.get('hypertension'))
    heart_disease = float(request.form.get('heart_disease'))
    bmi = float(request.form.get('bmi'))
    HbA1c_level = float(request.form.get('HbA1c_level'))
    blood_glucose_level = float(request.form.get('blood_glucose_level'))
    value = [gender,age,hypertension,heart_disease,bmi,HbA1c_level,blood_glucose_level]

    # here the function is calling which is defined above
    val = Diabetes(value)
    return render_template('diabitic.html',val = val)



# ****image model zone 

def process_image(model, classes, page):
    if 'image' not in request.files:
        return render_template(f'{page}.html', result="No image file provided")

    # Get the file from the request
    file = request.files['image']

    # Check if the file is empty
    if file.filename == '':
        return render_template(f'{page}.html', result="No selected file")

    if file:
        # Save the uploaded file
        filename = os.path.join(app.config['UPLOAD_FOLDER'], file.filename)
        file.save(filename)

        # Provide the image URL to the template
        image_url = f'{filename}'
        print(image_url)
        img = image.load_img(image_url, target_size = (420, 420))

        result = prediction(model, img, classes)
        print(image_url)
        return render_template(f'{page}.html', result=result, image=image_url)
    

def prediction(model, test_image, classes):
    print(model)
    print(test_image)
    print(classes)
    test_image = image.img_to_array(test_image)
    test_image = np.expand_dims(test_image, axis=0)
    out = classes[np.argmax(model.predict(test_image))]
    return out



# 2. ratinopathy

# this is for button
@app.route('/ratinopathy')
def ratinopathy():
    return render_template('ratinopathy.html')

@app.route('/predict', methods=['POST'])
def predict():
    return process_image(ratinopathy_model, ratinopathy_classes, 'ratinopathy')



#  3. alzheimer zone 

# this is for button
@app.route('/alzheimer')
def alzheimer():
    return render_template('alzheimer.html')


@app.route('/alzhiemerfnc', methods=['POST'])
def alzhiemerfnc():
    return process_image(alzehmir_model, alzehmir_class, 'alzheimer')




#  4. lung zone 

# this is for button
@app.route('/lung')
def lung():
    return render_template('lung.html')


@app.route('/predict_model2', methods=['POST'])
def predict_model2():
    return process_image(lung_model, lung_class, 'lung')




if __name__ == '__main__':
    os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)
    app.run(debug=True)
