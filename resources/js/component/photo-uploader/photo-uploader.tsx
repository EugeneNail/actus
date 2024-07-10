import "./photo-uploader.sass"
import React, {ChangeEvent} from "react";
import Icon from "../icon/icon";
import axios from "axios";

type Props = {
    name: string
    values: string[]
    deletePhoto: (name: string) => void
    onPhotosUploaded: (photos: string[]) => void
}

export default function PhotoUploader({name, values, deletePhoto, onPhotosUploaded}: Props) {
    async function loadBase64Images(event: ChangeEvent<HTMLInputElement>) {
        const files = event.target.files ?? [] as File[]
        const formData = new FormData();

        for (let i = 0; i < files.length; i++) {
            formData.append('photos[]', files[i])
        }

        const {data, status} = await axios.post("/photos", formData)
        if (status == 201) {
            onPhotosUploaded(data)
        }
    }


    return (
        <div className="photo-uploader">
            <p className="photo-uploader__label">Фотографии</p>
            <input className="photo-uploader__input" name={name} id={name} type="file" multiple accept="image/*" onChange={loadBase64Images}/>
            <div className="photo-uploader__photos">
                {values && values.map((name) => (
                    <div className="photo-uploader__image-container" key={name}>
                        <div className="photo-uploader__delete-button" onClick={() => deletePhoto(name)}>
                            <Icon className="photo-uploader__delete-button-icon" bold name="close"/>
                        </div>
                        <img className="photo-uploader__img" src={`/photos/${name}`} alt={name}/>
                    </div>
                ))}
                <label htmlFor={name} className="photo-uploader__button">
                    <Icon className="photo-uploader__icon" name="add_photo_alternate"/>
                </label>
            </div>

        </div>
    )
}
