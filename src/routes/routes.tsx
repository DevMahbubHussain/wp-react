import React from 'react'
import { createHashRouter } from 'react-router-dom'
import HomePage from '../page/HomePage'
import JobsPage from '../page/jobs/JobsPage'
import CreateJob from '../page/jobs/CreateJob'
import EditJob from '../page/jobs/EditJob'
import SettingsPage from '../page/Settings/SettingsPage'

const routes = createHashRouter([

    {
        path:'/',
        element:<HomePage/>
    },
    {
        path:'/jobs',
        element:<JobsPage/>
    },
    {
        path:'/jobs/new',
        element:<CreateJob/>
    },
    {
        path:'/jobs/edit/:id',
        element:<EditJob/>
    },
    {
        path:'/settings',
        element:<SettingsPage/>,
        children:[
         {
            path:'profile',
            element:'Profile Settings Page'
        },
        {
            path:'account',
            element:'Accout Settings Page'
        }
     ]

    }   
]);

export default routes